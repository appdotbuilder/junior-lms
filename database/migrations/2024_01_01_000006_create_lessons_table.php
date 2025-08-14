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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable()->comment('HTML content for the lesson');
            $table->integer('order_index')->default(0)->comment('Order within the course');
            $table->enum('content_type', ['text', 'video', 'interactive', 'mixed'])->default('mixed');
            $table->string('video_url')->nullable();
            $table->json('attachments')->nullable()->comment('Array of file attachments');
            $table->integer('estimated_duration')->default(45)->comment('Estimated duration in minutes');
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index(['course_id', 'order_index']);
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};