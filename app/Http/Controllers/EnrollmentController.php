<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    public function enroll(Course $course)
    {
        if ($course->isEnrolledBy(auth()->user())) {
            return back()->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }

        if ($course->price > 0) {
            return redirect()->route('payment.checkout', $course);
        }

        $enrollment = Enrollment::create([
            'student_id' => auth()->id(),
            'course_id' => $course->id,
        ]);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Inscription réussie !');
    }

    public function myCourses()
    {
        $enrollments = auth()->user()->enrollments()
            ->with('course.teacher')
            ->latest()
            ->paginate(12);

        return view('enrollments.my-courses', compact('enrollments'));
    }

    public function showProgress(Course $course)
    {
        if (!$course->isEnrolledBy(auth()->user())) {
            return redirect()->route('courses.show', $course)
                ->with('error', 'Vous n\'êtes pas inscrit à ce cours.');
        }

        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $course->id)
            ->with(['course.lessons' => function ($query) {
                $query->ordered();
            }])
            ->firstOrFail();

        return view('enrollments.progress', compact('enrollment'));
    }

    public function unenroll(Course $course)
    {
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $course->id)
            ->firstOrFail();

        $enrollment->delete();

        return redirect()->route('enrollments.my-courses')
            ->with('success', 'Vous vous êtes désinscrit du cours avec succès.');
    }

    /**
     * Store a new enrollment.
     */
    public function store(Course $course)
    {
        // Reuse the same logic as the enroll method
        return $this->enroll($course);
    }
}
