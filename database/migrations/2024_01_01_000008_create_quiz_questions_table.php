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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer', 'essay'])->default('multiple_choice');
            $table->json('options')->nullable()->comment('Array of answer options for multiple choice');
            $table->json('correct_answers')->comment('Array of correct answer indices or text');
            $table->text('explanation')->nullable()->comment('Explanation shown after answering');
            $table->decimal('points', 5, 2)->default(1.00);
            $table->integer('order_index')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index(['quiz_id', 'order_index']);
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};