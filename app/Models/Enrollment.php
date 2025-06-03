<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'completed',
        'progress',
        'completed_at',
        'amount',
        'payment_status',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'progress' => 'integer',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Helper methods
    public function updateProgress()
    {
        $total_lessons = $this->course->lessons()->count();
        if ($total_lessons === 0) return;

        $completed_lessons = $this->course->lessons()
            ->whereHas('completions', function ($query) {
                $query->where('user_id', $this->student_id);
            })
            ->count();

        $this->progress = ($completed_lessons / $total_lessons) * 100;
        
        if ($this->progress === 100 && !$this->completed) {
            $this->completed = true;
            $this->completed_at = now();
        }

        $this->save();
    }
} 
?>