<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CourseEnrollment
 *
 * @property int $id
 * @property int $course_id
 * @property int $student_id
 * @property string $status
 * @property float|null $final_grade
 * @property \Illuminate\Support\Carbon $enrolled_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Course $course
 * @property-read \App\Models\User $student
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereFinalGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereEnrolledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourseEnrollment enrolled()
 * 
 * @mixin \Eloquent
 */
class CourseEnrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_id',
        'student_id',
        'status',
        'final_grade',
        'enrolled_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'course_id' => 'integer',
        'student_id' => 'integer',
        'final_grade' => 'decimal:2',
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Scope a query to only include enrolled students.
     */
    public function scopeEnrolled($query)
    {
        return $query->where('status', 'enrolled');
    }

    /**
     * Get the course for this enrollment.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the student for this enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}