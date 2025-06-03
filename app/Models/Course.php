<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'teacher_id',
        'thumbnail',
        'price',
        'is_published',
        'category',
        'level', // 'beginner', 'intermediate', 'advanced'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Relations
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')
            ->withPivot('completed', 'progress')
            ->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    // Helper methods
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function getTotalStudentsAttribute()
    {
        return $this->enrollments()->count();
    }

    public function isEnrolledBy(User $user)
    {
        return $this->enrollments()->where('student_id', $user->id)->exists();
    }
} 
?>