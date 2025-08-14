<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@sciencehub.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'administrator',
            'is_active' => true,
        ]);

        // Create teachers
        $teachers = User::factory()->teacher()->count(5)->create();
        
        // Create a specific demo teacher
        $demoTeacher = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'teacher@sciencehub.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'subject_specialization' => 'Physical Science',
            'bio' => 'Experienced science educator with 10+ years of teaching junior high students.',
            'is_active' => true,
        ]);

        // Add demo teacher to teachers collection
        $teachers->push($demoTeacher);

        // Create students
        $students = User::factory()->student()->count(30)->create();
        
        // Create a demo student
        $demoStudent = User::create([
            'name' => 'Alex Chen',
            'email' => 'student@sciencehub.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'student',
            'grade' => '8th',
            'birth_date' => now()->subYears(13),
            'is_active' => true,
        ]);

        $students->push($demoStudent);

        // Create courses
        $courses = collect();
        
        foreach ($teachers as $teacher) {
            $teacherCourses = Course::factory()
                ->count(random_int(1, 3))
                ->create(['teacher_id' => $teacher->id]);
            
            $courses = $courses->merge($teacherCourses);
        }

        // Create specific demo courses
        $demoCourses = [
            [
                'title' => 'Introduction to Physical Science - 8th Grade',
                'code' => 'PHY801',
                'description' => 'Explore the fundamental principles of matter, energy, and motion. This course covers basic physics and chemistry concepts designed for 8th grade students.',
                'grade_level' => '8th',
                'subject' => 'Physical Science',
                'teacher_id' => $demoTeacher->id,
                'status' => 'published',
                'duration_weeks' => 16,
            ],
            [
                'title' => 'Biology Basics - 7th Grade',
                'code' => 'BIO701',
                'description' => 'Discover the amazing world of living organisms. From cells to ecosystems, learn about life processes and biological diversity.',
                'grade_level' => '7th',
                'subject' => 'Biology',
                'teacher_id' => $teachers[0]->id,
                'status' => 'published',
                'duration_weeks' => 15,
            ],
            [
                'title' => 'Earth and Space Science - 9th Grade',
                'code' => 'EAR901',
                'description' => 'Journey through our planet and beyond! Study geology, meteorology, astronomy, and environmental science.',
                'grade_level' => '9th',
                'subject' => 'Earth Science',
                'teacher_id' => $teachers[1]->id,
                'status' => 'published',
                'duration_weeks' => 18,
            ]
        ];

        foreach ($demoCourses as $courseData) {
            $course = Course::create($courseData);
            $courses->push($course);
        }

        // Create lessons for each course
        foreach ($courses as $course) {
            $lessonCount = random_int(8, 15);
            
            for ($i = 1; $i <= $lessonCount; $i++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => "Lesson {$i}: " . fake()->sentence(3),
                    'description' => fake()->paragraph(),
                    'content' => $this->generateLessonContent(),
                    'order_index' => $i,
                    'content_type' => fake()->randomElement(['text', 'video', 'interactive', 'mixed']),
                    'video_url' => fake()->optional()->url(),
                    'estimated_duration' => random_int(30, 60),
                    'is_published' => $i <= ($lessonCount * 0.8), // 80% published
                    'published_at' => $i <= ($lessonCount * 0.8) ? now()->subDays(random_int(1, 30)) : null,
                ]);
            }
        }

        // Create quizzes for courses
        foreach ($courses->where('status', 'published') as $course) {
            $quizCount = random_int(3, 6);
            
            for ($i = 1; $i <= $quizCount; $i++) {
                $quiz = Quiz::create([
                    'course_id' => $course->id,
                    'lesson_id' => $course->lessons->random()->id ?? null,
                    'title' => "Quiz {$i}: " . fake()->sentence(2),
                    'description' => fake()->paragraph(),
                    'time_limit' => random_int(15, 45),
                    'max_attempts' => random_int(2, 3),
                    'passing_score' => random_int(70, 80),
                    'shuffle_questions' => true,
                    'show_results_immediately' => fake()->boolean(80),
                    'is_published' => true,
                    'available_from' => now()->subDays(30),
                    'available_until' => now()->addDays(60),
                ]);

                // Create questions for quiz
                $questionCount = random_int(5, 10);
                for ($q = 1; $q <= $questionCount; $q++) {
                    QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question' => fake()->sentence() . '?',
                        'type' => 'multiple_choice',
                        'options' => [
                            fake()->sentence(3),
                            fake()->sentence(3),
                            fake()->sentence(3),
                            fake()->sentence(3),
                        ],
                        'correct_answers' => [random_int(0, 3)],
                        'explanation' => fake()->paragraph(),
                        'points' => 1.00,
                        'order_index' => $q,
                    ]);
                }
            }
        }

        // Create assignments
        foreach ($courses->where('status', 'published') as $course) {
            $assignmentCount = random_int(3, 5);
            
            for ($i = 1; $i <= $assignmentCount; $i++) {
                Assignment::create([
                    'course_id' => $course->id,
                    'lesson_id' => $course->lessons->random()->id ?? null,
                    'title' => "Assignment {$i}: " . fake()->sentence(2),
                    'description' => fake()->paragraph(2),
                    'instructions' => fake()->paragraph(3),
                    'max_points' => random_int(50, 100),
                    'due_date' => now()->addDays(random_int(7, 30)),
                    'allow_late_submission' => fake()->boolean(70),
                    'late_penalty_percent' => random_int(5, 15),
                    'allowed_file_types' => ['pdf', 'doc', 'docx', 'txt'],
                    'max_file_size_mb' => 10,
                    'is_published' => true,
                ]);
            }
        }

        // Enroll students in courses
        foreach ($students as $student) {
            $enrollmentCount = random_int(2, 4);
            $availableCourses = $courses->where('status', 'published')->random($enrollmentCount);
            
            foreach ($availableCourses as $course) {
                CourseEnrollment::create([
                    'course_id' => $course->id,
                    'student_id' => $student->id,
                    'status' => 'enrolled',
                    'enrolled_at' => now()->subDays(random_int(1, 30)),
                ]);
            }
        }

        $this->command->info('LMS data seeded successfully!');
        $this->command->info('Demo accounts created:');
        $this->command->info('Admin: admin@sciencehub.com / password');
        $this->command->info('Teacher: teacher@sciencehub.com / password');
        $this->command->info('Student: student@sciencehub.com / password');
    }

    /**
     * Generate sample lesson content.
     */
    public function generateLessonContent(): string
    {
        return '
            <h2>Learning Objectives</h2>
            <ul>
                <li>' . fake()->sentence() . '</li>
                <li>' . fake()->sentence() . '</li>
                <li>' . fake()->sentence() . '</li>
            </ul>
            
            <h2>Introduction</h2>
            <p>' . fake()->paragraph(3) . '</p>
            
            <h2>Key Concepts</h2>
            <p>' . fake()->paragraph(4) . '</p>
            
            <h3>Important Terms</h3>
            <ul>
                <li><strong>' . fake()->word() . ':</strong> ' . fake()->sentence() . '</li>
                <li><strong>' . fake()->word() . ':</strong> ' . fake()->sentence() . '</li>
                <li><strong>' . fake()->word() . ':</strong> ' . fake()->sentence() . '</li>
            </ul>
            
            <h2>Practice Problems</h2>
            <p>' . fake()->paragraph(2) . '</p>
            
            <h2>Summary</h2>
            <p>' . fake()->paragraph(3) . '</p>
        ';
    }
}