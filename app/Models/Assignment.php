<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Assignment
 *
 * @property int $id
 * @property int $course_id
 * @property int|null $lesson_id
 * @property string $title
 * @property string $description
 * @property string|null $instructions
 * @property float $max_points
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property bool $allow_late_submission
 * @property float $late_penalty_percent
 * @property array|null $allowed_file_types
 * @property int $max_file_size_mb
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\Lesson|null $lesson
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AssignmentSubmission[] $submissions
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereLessonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereMaxPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereAllowLateSubmission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereLatepenaltyPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereAllowedFileTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereMaxFileSizeMb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assignment published()
 * 
 * @mixin \Eloquent
 */
class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'lesson_id',
        'title',
        'description',
        'instructions',
        'max_points',
        'due_date',
        'allow_late_submission',
        'late_penalty_percent',
        'allowed_file_types',
        'max_file_size_mb',
        'is_published',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'lesson_id' => 'integer',
        'max_points' => 'decimal:2',
        'due_date' => 'datetime',
        'allow_late_submission' => 'boolean',
        'late_penalty_percent' => 'decimal:2',
        'allowed_file_types' => 'array',
        'max_file_size_mb' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * Scope a query to only include published assignments.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the course this assignment belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lesson this assignment belongs to.
     */
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the submissions for this assignment.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}