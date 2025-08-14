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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description');
            $table->text('instructions')->nullable();
            $table->decimal('max_points', 5, 2)->default(100.00);
            $table->timestamp('due_date')->nullable();
            $table->boolean('allow_late_submission')->default(true);
            $table->decimal('late_penalty_percent', 5, 2)->default(10.00);
            $table->json('allowed_file_types')->nullable()->comment('Array of allowed file extensions');
            $table->integer('max_file_size_mb')->default(10);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
            
            // Add indexes
            $table->index(['course_id', 'is_published']);
            $table->index('due_date');
            $table->index('lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};