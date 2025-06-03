<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:teacher,admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Course::query()
            ->with(['teacher', 'ratings'])
            ->withCount('enrollments')
            ->where('is_published', true);

        // Apply filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        // Apply sorting
        switch ($request->get('sort', 'newest')) {
            case 'popular':
                $query->orderBy('enrollments_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('ratings', 'rating')
                    ->orderBy('ratings_avg_rating', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $courses = $query->paginate(9);
        
        // Get enrolled course IDs for the authenticated user
        $enrolledCourseIds = [];
        if (auth()->check()) {
            $enrolledCourseIds = auth()->user()->enrollments()->pluck('course_id')->toArray();
        }

        return view('courses.index', compact('courses', 'enrolledCourseIds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Course::class);
        
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Course::class);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:programming,design,business,marketing',
            'level' => 'required|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $course = new Course($validated);
        $course->teacher_id = auth()->id();
        
        if ($request->hasFile('thumbnail')) {
            $course->thumbnail = $request->file('thumbnail')->store('courses', 'public');
        }
        
        $course->save();

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['teacher', 'lessons', 'ratings.user']);
        
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category' => 'required|in:programming,design,business,marketing',
            'level' => 'required|in:beginner,intermediate,advanced',
            'thumbnail' => 'nullable|image|max:2048',
            'is_published' => 'boolean'
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        
        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    public function togglePublish(Course $course)
    {
        $this->authorize('update', $course);

        $course->update(['is_published' => !$course->is_published]);

        return back()->with('success', 
            $course->is_published ? 'Course published successfully.' : 'Course unpublished successfully.');
    }
}
