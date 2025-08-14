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
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->text('content')->nullable()->comment('Text submission content');
            $table->json('attachments')->nullable()->comment('Array of uploaded files');
            $table->decimal('score', 5, 2)->nullable();
            $table->text('feedback')->nullable()->comment('Teacher feedback');
            $table->enum('status', ['draft', 'submitted', 'graded', 'returned'])->default('draft');
            $table->boolean('is_late')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('graded_at')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Add unique constraint and indexes
            $table->unique(['assignment_id', 'student_id']);
            $table->index(['student_id', 'status']);
            $table->index('submitted_at');
            $table->index('graded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};