<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'course_id',
        'order',
        'video_url',
        'duration',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'duration' => 'integer', // in minutes
    ];

    // Relations
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scopes
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeFreeLessons($query)
    {
        return $query->where('is_free', true);
    }

    // Helper methods
    public function isCompleted(User $user)
    {
        return $this->completions()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function markAsCompleted(User $user)
    {
        return $this->completions()->create([
            'user_id' => $user->id
        ]);
    }

    public function getNextLesson()
    {
        return static::where('course_id', $this->course_id)
            ->where('order', '>', $this->order)
            ->ordered()
            ->first();
    }

    public function getPreviousLesson()
    {
        return static::where('course_id', $this->course_id)
            ->where('order', '<', $this->order)
            ->ordered()
            ->latest('order')
            ->first();
    }
} 
?>