<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher,admin')->except(['show', 'complete']);
    }

    public function index(Course $course)
    {
        $this->authorize('update', $course);
        
        $lessons = $course->lessons()->ordered()->get();
        return view('lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        $this->authorize('update', $course);
        return view('lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:1',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        // Set order to last if not specified
        if (!isset($validated['order'])) {
            $validated['order'] = $course->lessons()->max('order') + 1;
        }

        $lesson = $course->lessons()->create($validated);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lesson-attachments', 'public');
                $lesson->attachments()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('courses.show', $course)
            ->with('success', 'Lesson created successfully.');
    }

    public function show(Lesson $lesson)
    {
        $course = $lesson->course;
        
        // Check if user is enrolled or is the teacher/admin
        $isEnrolled = auth()->user()->can('view', $course) || 
                     $course->isEnrolledBy(auth()->user());
        
        if (!$isEnrolled) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'You must be enrolled in this course to view lessons.');
        }

        // Get course progress data
        $courseLessons = $course->lessons()->ordered()->get();
        $totalLessonsCount = $courseLessons->count();
        $completedLessonsCount = auth()->user()->completedLessons()
            ->where('course_id', $course->id)
            ->count();
        $courseProgress = $totalLessonsCount > 0 
            ? round(($completedLessonsCount / $totalLessonsCount) * 100) 
            : 0;

        // Get previous and next lessons
        $currentIndex = $courseLessons->search(function($item) use ($lesson) {
            return $item->id === $lesson->id;
        });
        $previousLesson = $currentIndex > 0 ? $courseLessons[$currentIndex - 1] : null;
        $nextLesson = $currentIndex < $courseLessons->count() - 1 ? $courseLessons[$currentIndex + 1] : null;

        return view('lessons.show', compact(
            'lesson',
            'course',
            'isEnrolled',
            'courseLessons',
            'totalLessonsCount',
            'completedLessonsCount',
            'courseProgress',
            'previousLesson',
            'nextLesson'
        ));
    }

    public function edit(Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);
        return view('lessons.edit', compact('lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'order' => 'nullable|integer|min:0',
            'duration' => 'nullable|integer|min:1',
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ]);

        $lesson->update($validated);

        // Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('lesson-attachments', 'public');
                $lesson->attachments()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        // Handle attachment deletions
        if ($request->has('delete_attachments')) {
            $attachments = $lesson->attachments()->whereIn('id', $request->delete_attachments)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->path);
                $attachment->delete();
            }
        }

        return redirect()->route('lessons.show', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorize('update', $lesson->course);
        
        $course = $lesson->course;

        // Delete all attachments
        foreach ($lesson->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->path);
        }
        
        $lesson->delete();

        // Reorder remaining lessons
        $course->lessons()->ordered()->get()->each(function ($lesson, $index) {
            $lesson->update(['order' => $index + 1]);
        });

        return redirect()->route('courses.show', $course)
            ->with('success', 'Lesson deleted successfully.');
    }

    public function reorder(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'lessons' => 'required|array',
            'lessons.*' => 'required|integer|exists:lessons,id'
        ]);

        foreach ($request->lessons as $index => $lessonId) {
            $course->lessons()->where('id', $lessonId)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'Lessons reordered successfully.']);
    }

    public function complete(Course $course, Lesson $lesson)
    {
        // Verify user is enrolled
        if (!$course->isEnrolledBy(auth()->user())) {
            return back()->with('error', 'You must be enrolled in this course to mark lessons as complete.');
        }

        // Create or update completion record
        LessonCompletion::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'lesson_id' => $lesson->id,
                'course_id' => $course->id,
            ],
            [
                'completed_at' => now(),
            ]
        );

        // Update course progress
        $totalLessons = $course->lessons()->count();
        $completedLessons = auth()->user()->completedLessons()
            ->where('course_id', $course->id)
            ->count();
        
        $progress = ($completedLessons / $totalLessons) * 100;

        $enrollment = $course->enrollments()
            ->where('student_id', auth()->id())
            ->first();
        
        $enrollment->update(['progress' => $progress]);

        // If this was the last lesson, redirect to the course page
        if ($completedLessons === $totalLessons) {
            return redirect()->route('courses.show', $course)
                ->with('success', 'Congratulations! You have completed the course.');
        }

        // Find the next lesson
        $nextLesson = $course->lessons()
            ->ordered()
            ->where('order', '>', $lesson->order)
            ->first();

        if ($nextLesson) {
            return redirect()->route('lessons.show', $nextLesson)
                ->with('success', 'Lesson completed! Moving to next lesson.');
        }

        return back()->with('success', 'Lesson completed successfully.');
    }
}
