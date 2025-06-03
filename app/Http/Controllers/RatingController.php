<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10',
        ]);

        // Vérifier si l'utilisateur est inscrit au cours
        if (!$course->enrollments()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You must be enrolled in the course to rate it.');
        }

        // Vérifier si l'utilisateur a déjà noté ce cours
        if ($course->ratings()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'You have already rated this course.');
        }

        $rating = new Rating([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $course->ratings()->save($rating);

        return back()->with('success', 'Thank you for your review!');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10',
        ]);

        $rating = $course->ratings()->where('user_id', auth()->id())->firstOrFail();
        
        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your review has been updated.');
    }

    public function destroy(Course $course)
    {
        $rating = $course->ratings()->where('user_id', auth()->id())->firstOrFail();
        $rating->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
} 