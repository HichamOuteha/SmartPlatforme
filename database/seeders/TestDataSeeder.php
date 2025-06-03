<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create teacher user
        $teacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
        ]);

        // Create student user
        $student = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        // Create a course
        $course = Course::create([
            'title' => 'Test Course',
            'slug' => 'test-course',
            'description' => 'This is a test course',
            'teacher_id' => $teacher->id,
            'price' => 99.99,
            'is_published' => true,
            'category' => 'programming',
            'level' => 'beginner',
        ]);

        // Create an enrollment
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'progress' => 0,
            'payment_status' => 'completed',
            'amount' => 99.99,
        ]);
    }
} 