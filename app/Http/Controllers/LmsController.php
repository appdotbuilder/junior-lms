<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseEnrollment;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LmsController extends Controller
{
    /**
     * Display the LMS dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            // Show public LMS overview for non-authenticated users
            $stats = [
                'total_courses' => Course::published()->count(),
                'total_students' => User::students()->active()->count(),
                'total_teachers' => User::teachers()->active()->count(),
                'total_quizzes' => Quiz::published()->count(),
            ];
            
            $featured_courses = Course::published()
                ->with('teacher')
                ->limit(6)
                ->get();
            
            return Inertia::render('lms/overview', [
                'stats' => $stats,
                'featured_courses' => $featured_courses,
            ]);
        }
        
        // Redirect authenticated users based on their role
        switch ($user->role) {
            case 'student':
                // Get enrolled courses with progress
                $enrollments = CourseEnrollment::where('student_id', $user->id)
                    ->with(['course.teacher', 'course.lessons'])
                    ->enrolled()
                    ->get();
                
                // Get recent assignments
                $recent_assignments = Assignment::whereIn('course_id', $enrollments->pluck('course_id'))
                    ->published()
                    ->where('due_date', '>=', now())
                    ->orderBy('due_date')
                    ->limit(5)
                    ->get();
                
                // Get recent quizzes
                $recent_quizzes = Quiz::whereIn('course_id', $enrollments->pluck('course_id'))
                    ->published()
                    ->where('available_until', '>=', now())
                    ->orderBy('available_until')
                    ->limit(5)
                    ->get();
                
                return Inertia::render('lms/student-dashboard', [
                    'enrollments' => $enrollments,
                    'recent_assignments' => $recent_assignments,
                    'recent_quizzes' => $recent_quizzes,
                ]);
                
            case 'teacher':
                // Get courses taught by this teacher
                $courses = Course::where('teacher_id', $user->id)
                    ->with(['enrollments.student', 'lessons', 'quizzes', 'assignments'])
                    ->get();
                
                // Get recent student activity
                $recent_submissions = Assignment::whereIn('course_id', $courses->pluck('id'))
                    ->with(['submissions' => function($query) {
                        $query->submitted()
                              ->orderBy('submitted_at', 'desc')
                              ->with('student')
                              ->limit(10);
                    }])
                    ->get()
                    ->pluck('submissions')
                    ->flatten()
                    ->take(10);
                
                return Inertia::render('lms/teacher-dashboard', [
                    'courses' => $courses,
                    'recent_submissions' => $recent_submissions,
                ]);
                
            case 'administrator':
                // System-wide statistics
                $stats = [
                    'total_users' => User::active()->count(),
                    'total_students' => User::students()->active()->count(),
                    'total_teachers' => User::teachers()->active()->count(),
                    'total_courses' => Course::count(),
                    'published_courses' => Course::published()->count(),
                    'total_assignments' => Assignment::count(),
                    'total_quizzes' => Quiz::count(),
                ];
                
                // Recent activity
                $recent_users = User::latest()->limit(10)->get();
                $recent_courses = Course::with('teacher')->latest()->limit(10)->get();
                
                return Inertia::render('lms/admin-dashboard', [
                    'stats' => $stats,
                    'recent_users' => $recent_users,
                    'recent_courses' => $recent_courses,
                ]);
                
            default:
                $stats = [
                    'total_courses' => Course::published()->count(),
                    'total_students' => User::students()->active()->count(),
                    'total_teachers' => User::teachers()->active()->count(),
                    'total_quizzes' => Quiz::published()->count(),
                ];
                
                $featured_courses = Course::published()
                    ->with('teacher')
                    ->limit(6)
                    ->get();
                
                return Inertia::render('lms/overview', [
                    'stats' => $stats,
                    'featured_courses' => $featured_courses,
                ]);
        }
    }
}