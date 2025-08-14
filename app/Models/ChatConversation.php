<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ChatConversation
 *
 * @property int $id
 * @property int|null $course_id
 * @property string|null $title
 * @property string $type
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $last_message_at
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course|null $course
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatParticipant[] $participants
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatMessage[] $messages
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereLastMessageAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatConversation active()
 * 
 * @mixin \Eloquent
 */
class ChatConversation extends Model
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
        'type',
        'is_active',
        'last_message_at',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'is_active' => 'boolean',
        'last_message_at' => 'datetime',
        'created_by' => 'integer',
    ];

    /**
     * Scope a query to only include active conversations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the course this conversation belongs to.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who created this conversation.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the participants in this conversation.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(ChatParticipant::class, 'conversation_id');
    }

    /**
     * Get the messages in this conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }
}