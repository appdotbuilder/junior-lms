<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('code')->unique()->comment('Course code like SCI101');
            $table->text('description');
            $table->string('grade_level')->comment('7th, 8th, or 9th grade');
            $table->string('subject')->default('Science');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('cover_image')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('duration_weeks')->default(16)->comment('Course duration in weeks');
            $table->timestamps();
            
            // Add indexes
            $table->index('status');
            $table->index('grade_level');
            $table->index('teacher_id');
            $table->index(['status', 'grade_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};