<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user && $user->isTeacher()) {
            // Teachers see only their courses
            $courses = Course::where('teacher_id', $user->id)
                ->with(['enrollments', 'lessons'])
                ->latest()
                ->paginate(12);
        } elseif ($user && $user->isAdministrator()) {
            // Administrators see all courses
            $courses = Course::with(['teacher', 'enrollments', 'lessons'])
                ->latest()
                ->paginate(12);
        } else {
            // Students and public see only published courses
            $courses = Course::published()
                ->with(['teacher', 'enrollments'])
                ->latest()
                ->paginate(12);
        }
        
        return Inertia::render('courses/index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $teachers = User::teachers()->active()->get(['id', 'name']);
        
        return Inertia::render('courses/create', [
            'teachers' => $teachers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $user = Auth::user();
        
        // Check if user can view this course
        if ($course->status !== 'published' && 
            (!$user || (!$user->isTeacher() && !$user->isAdministrator()))) {
            abort(403);
        }
        
        $course->load([
            'teacher',
            'lessons' => function($query) {
                $query->published()->orderBy('order_index');
            },
            'quizzes' => function($query) {
                $query->published();
            },
            'assignments' => function($query) {
                $query->published();
            },
            'forums'
        ]);
        
        // Check if current user is enrolled (for students)
        $enrollment = null;
        if ($user && $user->isStudent()) {
            $enrollment = $course->enrollments()
                ->where('student_id', $user->id)
                ->first();
        }
        
        return Inertia::render('courses/show', [
            'course' => $course,
            'enrollment' => $enrollment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        
        $teachers = User::teachers()->active()->get(['id', 'name']);
        
        return Inertia::render('courses/edit', [
            'course' => $course,
            'teachers' => $teachers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}