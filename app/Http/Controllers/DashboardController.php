<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $data = [];

        if ($user->hasRole('admin')) {
            $data = $this->getAdminDashboardData();
        } elseif ($user->hasRole('teacher')) {
            $data = $this->getTeacherDashboardData($user);
        } else {
            $data = $this->getStudentDashboardData($user);
        }

        return view('dashboard', $data);
    }

    private function getAdminDashboardData()
    {
        $totalStudents = User::role('student')->count();
        $totalTeachers = User::role('teacher')->count();
        $totalCourses = Course::count();
        $totalRevenue = Enrollment::where('payment_status', 'completed')
            ->sum('amount');

        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $popularCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        $monthlyRevenue = Enrollment::where('payment_status', 'completed')
            ->whereBetween('created_at', [now()->subMonths(11), now()])
            ->select(
                DB::raw('sum(amount) as revenue'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $coursesByCategory = Course::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->get();

        return compact(
            'totalStudents',
            'totalTeachers',
            'totalCourses',
            'totalRevenue',
            'recentEnrollments',
            'popularCourses',
            'monthlyRevenue',
            'coursesByCategory'
        );
    }

    private function getTeacherDashboardData(User $teacher)
    {
        $courses = $teacher->courses()
            ->withCount(['enrollments', 'lessons'])
            ->withAvg('ratings', 'rating')
            ->get();

        $totalStudents = $teacher->courses()
            ->withCount('enrollments')
            ->get()
            ->sum('enrollments_count');

        $totalRevenue = Enrollment::whereIn('course_id', $teacher->courses()->pluck('id'))
            ->where('payment_status', 'completed')
            ->sum('amount');

        $recentEnrollments = Enrollment::whereIn('course_id', $teacher->courses()->pluck('id'))
            ->with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $courseRatings = $teacher->courses()
            ->with(['ratings' => function ($query) {
                $query->latest()->take(5)->with('user');
            }])
            ->get()
            ->pluck('ratings')
            ->flatten();

        $monthlyRevenue = Enrollment::whereIn('course_id', $teacher->courses()->pluck('id'))
            ->where('payment_status', 'completed')
            ->whereBetween('created_at', [now()->subMonths(11), now()])
            ->select(
                DB::raw('sum(amount) as revenue'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return compact(
            'courses',
            'totalStudents',
            'totalRevenue',
            'recentEnrollments',
            'courseRatings',
            'monthlyRevenue'
        );
    }

    private function getStudentDashboardData(User $student)
    {
        $enrolledCourses = $student->enrollments()
            ->with(['course.teacher', 'course.lessons'])
            ->latest()
            ->get();

        $inProgressCourses = $enrolledCourses
            ->where('progress', '<', 100)
            ->sortByDesc('updated_at');

        $completedCourses = $enrolledCourses
            ->where('progress', 100)
            ->sortByDesc('updated_at');

        $certificates = $student->certificates()
            ->with('course')
            ->latest()
            ->get();

        $recentLessons = $student->completedLessons()
            ->with(['lesson.course'])
            ->latest('completed_at')
            ->take(5)
            ->get();

        $recommendedCourses = Course::whereNotIn('id', $enrolledCourses->pluck('course_id'))
            ->where('is_published', true)
            ->withAvg('ratings', 'rating')
            ->withCount('enrollments')
            ->orderByDesc('ratings_avg_rating')
            ->take(3)
            ->get();

        return compact(
            'enrolledCourses',
            'inProgressCourses',
            'completedCourses',
            'certificates',
            'recentLessons',
            'recommendedCourses'
        );
    }
}
