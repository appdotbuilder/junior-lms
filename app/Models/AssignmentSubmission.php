<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\AssignmentSubmission
 *
 * @property int $id
 * @property int $assignment_id
 * @property int $student_id
 * @property string|null $content
 * @property array|null $attachments
 * @property float|null $score
 * @property string|null $feedback
 * @property string $status
 * @property bool $is_late
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $graded_at
 * @property int|null $graded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Assignment $assignment
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User|null $grader
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereIsLate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereGradedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereGradedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssignmentSubmission submitted()
 * 
 * @mixin \Eloquent
 */
class AssignmentSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'attachments',
        'score',
        'feedback',
        'status',
        'is_late',
        'submitted_at',
        'graded_at',
        'graded_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assignment_id' => 'integer',
        'student_id' => 'integer',
        'attachments' => 'array',
        'score' => 'decimal:2',
        'is_late' => 'boolean',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'graded_by' => 'integer',
    ];

    /**
     * Scope a query to only include submitted assignments.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Get the assignment for this submission.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student for this submission.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the grader for this submission.
     */
    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}