<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Lesson
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string|null $description
 * @property string|null $content
 * @property int $order_index
 * @property string $content_type
 * @property string|null $video_url
 * @property array|null $attachments
 * @property int $estimated_duration
 * @property bool $is_published
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[] $quizzes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Assignment[] $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\StudentProgress[] $progress
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson query()
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereOrderIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereContentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereEstimatedDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Lesson published()
 * 
 * @mixin \Eloquent
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'content',
        'order_index',
        'content_type',
        'video_url',
        'attachments',
        'estimated_duration',
        'is_published',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'order_index' => 'integer',
        'estimated_duration' => 'integer',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'attachments' => 'array',
    ];

    /**
     * Scope a query to only include published lessons.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the course this lesson belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the quizzes for this lesson.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the assignments for this lesson.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get student progress for this lesson.
     */
    public function progress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }
}