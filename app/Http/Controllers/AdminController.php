<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        // Récupérer des statistiques pour le tableau de bord admin
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $recentUsers = User::latest()->take(5)->get();
        $pendingCourses = Course::where('is_published', false)->count();
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCourses',
            'recentUsers',
            'pendingCourses'
        ));
    }
} 