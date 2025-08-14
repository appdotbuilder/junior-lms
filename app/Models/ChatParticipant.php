<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ChatParticipant
 *
 * @property int $id
 * @property int $conversation_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $joined_at
 * @property \Illuminate\Support\Carbon|null $last_read_at
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\ChatConversation $conversation
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereJoinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereLastReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatParticipant active()
 * 
 * @mixin \Eloquent
 */
class ChatParticipant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'conversation_id',
        'user_id',
        'joined_at',
        'last_read_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'conversation_id' => 'integer',
        'user_id' => 'integer',
        'joined_at' => 'datetime',
        'last_read_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active participants.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the conversation this participant belongs to.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    /**
     * Get the user for this participant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}