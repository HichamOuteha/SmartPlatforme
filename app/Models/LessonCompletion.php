<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    // Events
    protected static function booted()
    {
        static::created(function ($completion) {
            $lesson = $completion->lesson;
            $course = $lesson->course;
            $enrollment = Enrollment::where('student_id', $completion->user_id)
                ->where('course_id', $course->id)
                ->first();

            if ($enrollment) {
                $enrollment->updateProgress();
            }
        });
    }
}
?> 