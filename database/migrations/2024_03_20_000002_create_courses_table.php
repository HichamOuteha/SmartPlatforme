<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->boolean('is_published')->default(false);
            $table->string('category');
            $table->string('level')->default('beginner');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
} 