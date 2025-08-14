<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ForumPost
 *
 * @property int $id
 * @property int $forum_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property string $content
 * @property array|null $attachments
 * @property bool $is_pinned
 * @property bool $is_edited
 * @property \Illuminate\Support\Carbon|null $edited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\DiscussionForum $forum
 * @property-read \App\Models\User $user
 * @property-read \App\Models\ForumPost|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ForumPost[] $replies
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost query()
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereForumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereIsEdited($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereEditedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ForumPost topLevel()
 * 
 * @mixin \Eloquent
 */
class ForumPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'forum_id',
        'user_id',
        'parent_id',
        'content',
        'attachments',
        'is_pinned',
        'is_edited',
        'edited_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'forum_id' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'attachments' => 'array',
        'is_pinned' => 'boolean',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Scope a query to only include top-level posts.
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get the forum this post belongs to.
     */
    public function forum(): BelongsTo
    {
        return $this->belongsTo(DiscussionForum::class, 'forum_id');
    }

    /**
     * Get the user who created this post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent post (for replies).
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'parent_id');
    }

    /**
     * Get the replies to this post.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }
}