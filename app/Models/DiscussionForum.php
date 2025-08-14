<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\DiscussionForum
 *
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property string|null $description
 * @property bool $is_pinned
 * @property bool $is_locked
 * @property int $posts_count
 * @property \Illuminate\Support\Carbon|null $last_activity
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumPost[] $posts
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereIsLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum wherePostsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereLastActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiscussionForum pinned()
 * 
 * @mixin \Eloquent
 */
class DiscussionForum extends Model
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
        'is_pinned',
        'is_locked',
        'posts_count',
        'last_activity',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'posts_count' => 'integer',
        'last_activity' => 'datetime',
        'created_by' => 'integer',
    ];

    /**
     * Scope a query to only include pinned forums.
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Get the course this forum belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created this forum.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the posts for this forum.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'forum_id');
    }
}