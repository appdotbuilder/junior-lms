<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\QuizAttempt
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $student_id
 * @property array $answers
 * @property float|null $score
 * @property int|null $time_taken
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Quiz $quiz
 * @property-read \App\Models\User $student
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereTimeTaken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizAttempt completed()
 * 
 * @mixin \Eloquent
 */
class QuizAttempt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quiz_id',
        'student_id',
        'answers',
        'score',
        'time_taken',
        'started_at',
        'completed_at',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quiz_id' => 'integer',
        'student_id' => 'integer',
        'answers' => 'array',
        'score' => 'decimal:2',
        'time_taken' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Scope a query to only include completed attempts.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Get the quiz for this attempt.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the student for this attempt.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}