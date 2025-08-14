<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StudentProgress
 *
 * @property int $id
 * @property int $student_id
 * @property int $course_id
 * @property int|null $lesson_id
 * @property string $status
 * @property float $progress_percentage
 * @property int $time_spent
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $last_accessed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $student
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Lesson|null $lesson
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereProgressPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereTimeSpent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereLastAccessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentProgress completed()
 * 
 * @mixin \Eloquent
 */
class StudentProgress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'course_id',
        'lesson_id',
        'status',
        'progress_percentage',
        'time_spent',
        'started_at',
        'completed_at',
        'last_accessed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'student_id' => 'integer',
        'course_id' => 'integer',
        'lesson_id' => 'integer',
        'progress_percentage' => 'decimal:2',
        'time_spent' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'last_accessed_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'student_progress';

    /**
     * Scope a query to only include completed progress.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the student for this progress.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the course for this progress.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson for this progress.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}