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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['student', 'teacher', 'administrator'])->default('student')->after('email');
            $table->string('avatar')->nullable()->after('role');
            $table->text('bio')->nullable()->after('avatar');
            $table->date('birth_date')->nullable()->after('bio');
            $table->string('grade')->nullable()->after('birth_date')->comment('Grade level for students');
            $table->string('subject_specialization')->nullable()->after('grade')->comment('Subject specialization for teachers');
            $table->boolean('is_active')->default(true)->after('subject_specialization');
            
            // Add indexes
            $table->index('role');
            $table->index('is_active');
            $table->index(['role', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['role', 'is_active']);
            $table->dropColumn([
                'role',
                'avatar',
                'bio',
                'birth_date',
                'grade',
                'subject_specialization',
                'is_active'
            ]);
        });
    }
};