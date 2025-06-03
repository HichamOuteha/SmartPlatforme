<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome'); // ou une autre vue
    }
    
    public function dashboard()
    {
        $user = auth()->user();
        
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }
}
