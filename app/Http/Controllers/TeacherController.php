<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    public function dashboard()
    {
        $stats = [
            'total_courses' => Auth::user()->courses()->count(),
            'total_students' => Auth::user()->courses()->withCount('enrollments')->get()->sum('enrollments_count'),
            'average_rating' => Auth::user()->courses()->withAvg('ratings', 'rating')->get()->avg('ratings_avg_rating'),
            'recent_courses' => Auth::user()->courses()->latest()->take(5)->get(),
            'recent_enrollments' => Auth::user()->courses()->with(['enrollments.user'])->latest()->take(5)->get(),
        ];

        return view('teacher.dashboard', compact('stats'));
    }

    public function show(User $teacher)
    {
        abort_if($teacher->role !== 'teacher', 404);

        $courses = $teacher->courses()
            ->where('is_published', true)
            ->withCount('enrollments')
            ->withAvg('ratings', 'rating')
            ->paginate(9);

        return view('teacher.show', compact('teacher', 'courses'));
    }

    public function register()
    {
        return view('teacher.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'biography' => 'required|string|min:100',
            'expertise' => 'required|array|min:1',
            'expertise.*' => 'string|distinct',
            'website' => 'nullable|url',
            'social_links' => 'nullable|array',
            'social_links.*' => 'url',
        ]);

        $user = auth()->user();
        $user->update([
            'role' => 'teacher',
            'biography' => $request->biography,
            'expertise' => $request->expertise,
            'website' => $request->website,
            'social_links' => $request->social_links,
        ]);

        return redirect()->route('teacher.dashboard')
            ->with('success', 'Welcome to teaching! You can now create courses.');
    }
} 