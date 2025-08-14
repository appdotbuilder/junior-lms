<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Course>
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradeLevel = fake()->randomElement(['7th', '8th', '9th']);
        $subjects = [
            'Physical Science',
            'Chemistry Basics',
            'Biology Fundamentals',
            'Earth Science',
            'Physics Introduction',
            'Environmental Science',
            'Space Science',
            'Life Science'
        ];
        
        $subject = fake()->randomElement($subjects);
        $code = strtoupper(substr($subject, 0, 3)) . substr($gradeLevel, 0, 1) . fake()->numberBetween(10, 99);
        
        return [
            'title' => $subject . ' - ' . $gradeLevel . ' Grade',
            'code' => $code,
            'description' => fake()->paragraph(3),
            'grade_level' => $gradeLevel,
            'subject' => $subject,
            'teacher_id' => User::factory()->teacher(),
            'cover_image' => null,
            'status' => fake()->randomElement(['draft', 'published', 'published', 'published']), // More published
            'duration_weeks' => fake()->numberBetween(12, 18),
        ];
    }

    /**
     * Indicate that the course is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    /**
     * Indicate that the course is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}