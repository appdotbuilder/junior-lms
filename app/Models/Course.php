<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Course
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property string $description
 * @property string $grade_level
 * @property string $subject
 * @property int $teacher_id
 * @property string|null $cover_image
 * @property string $status
 * @property int $duration_weeks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $teacher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CourseEnrollment[] $enrollments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesson[] $lessons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Quiz[] $quizzes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Assignment[] $assignments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DiscussionForum[] $forums
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $students
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Course query()
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereGradeLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereDurationWeeks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Course published()
 * @method static \Database\Factories\CourseFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'code',
        'description',
        'grade_level',
        'subject',
        'teacher_id',
        'cover_image',
        'status',
        'duration_weeks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duration_weeks' => 'integer',
        'teacher_id' => 'integer',
    ];

    /**
     * Scope a query to only include published courses.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Get the teacher who teaches this course.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the enrollments for this course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    /**
     * Get enrolled students through enrollments.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'course_enrollments', 'course_id', 'student_id')
                    ->withPivot(['status', 'final_grade', 'enrolled_at', 'completed_at'])
                    ->withTimestamps();
    }

    /**
     * Get the lessons for this course.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order_index');
    }

    /**
     * Get the quizzes for this course.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get the assignments for this course.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the discussion forums for this course.
     */
    public function forums(): HasMany
    {
        return $this->hasMany(DiscussionForum::class);
    }
}