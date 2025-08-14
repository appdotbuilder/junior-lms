<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'student',
            'avatar' => null,
            'bio' => fake()->optional()->paragraph(),
            'birth_date' => fake()->optional()->dateTimeBetween('-16 years', '-12 years'),
            'grade' => fake()->optional()->randomElement(['7th', '8th', '9th']),
            'subject_specialization' => null,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a teacher.
     */
    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'teacher',
            'subject_specialization' => fake()->randomElement([
                'Physical Science',
                'Chemistry',
                'Biology',
                'Earth Science',
                'Physics',
                'Environmental Science'
            ]),
            'grade' => null,
            'birth_date' => fake()->dateTimeBetween('-50 years', '-25 years'),
        ]);
    }

    /**
     * Indicate that the user is an administrator.
     */
    public function administrator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'administrator',
            'subject_specialization' => null,
            'grade' => null,
            'birth_date' => fake()->dateTimeBetween('-50 years', '-30 years'),
        ]);
    }

    /**
     * Indicate that the user is a student.
     */
    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'student',
            'grade' => fake()->randomElement(['7th', '8th', '9th']),
            'subject_specialization' => null,
            'birth_date' => fake()->dateTimeBetween('-16 years', '-12 years'),
        ]);
    }
}
