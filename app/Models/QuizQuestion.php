<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\QuizQuestion
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $question
 * @property string $type
 * @property array|null $options
 * @property array $correct_answers
 * @property string|null $explanation
 * @property float $points
 * @property int $order_index
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Quiz $quiz
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereQuizId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereCorrectAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereExplanation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QuizQuestion whereUpdatedAt($value)
 * 
 * @mixin \Eloquent
 */
class QuizQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answers',
        'explanation',
        'points',
        'order_index',
        'image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quiz_id' => 'integer',
        'options' => 'array',
        'correct_answers' => 'array',
        'points' => 'decimal:2',
        'order_index' => 'integer',
    ];

    /**
     * Get the quiz this question belongs to.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}