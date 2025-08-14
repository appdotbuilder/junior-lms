import React from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import type { SharedData } from '@/types';

interface Teacher {
    id: number;
    name: string;
    bio?: string;
    subject_specialization?: string;
}

interface Lesson {
    id: number;
    title: string;
    description?: string;
    order_index: number;
    estimated_duration: number;
    is_published: boolean;
}

interface Quiz {
    id: number;
    title: string;
    description?: string;
    time_limit?: number;
    max_attempts: number;
    passing_score: number;
}

interface Assignment {
    id: number;
    title: string;
    description: string;
    due_date?: string;
    max_points: number;
}

interface Forum {
    id: number;
    title: string;
    description?: string;
    posts_count: number;
    is_pinned: boolean;
}

interface Course {
    id: number;
    title: string;
    code: string;
    description: string;
    grade_level: string;
    subject: string;
    cover_image?: string;
    status: string;
    duration_weeks: number;
    teacher: Teacher;
    lessons: Lesson[];
    quizzes: Quiz[];
    assignments: Assignment[];
    forums: Forum[];
}

interface Enrollment {
    id: number;
    status: string;
    final_grade?: number;
    enrolled_at: string;
}

interface Props {
    course: Course;
    enrollment?: Enrollment;
    [key: string]: unknown;
}

export default function CourseShow({ course, enrollment }: Props) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    const handleEnroll = () => {
        router.post(route('enrollments.store'), {
            course_id: course.id
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const canEdit = user && (user.role === 'administrator' || 
                            (user.role === 'teacher' && course.teacher.id === user.id));

    return (
        <AppShell>
            <Head title={`${course.title} - ScienceHub LMS`} />
            
            <div className="p-6 max-w-7xl mx-auto">
                {/* Course Header */}
                <div className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8">
                    <div className="md:flex">
                        {/* Course Image */}
                        <div className="md:w-1/3">
                            <div className="h-64 md:h-full bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                                {course.cover_image ? (
                                    <img src={course.cover_image} alt={course.title} className="w-full h-full object-cover" />
                                ) : (
                                    <span className="text-8xl">🧪</span>
                                )}
                            </div>
                        </div>
                        
                        {/* Course Info */}
                        <div className="md:w-2/3 p-8">
                            <div className="flex items-center justify-between mb-4">
                                <div className="flex items-center space-x-4">
                                    <span className="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                        {course.grade_level} Grade
                                    </span>
                                    <span className="text-sm text-gray-500 dark:text-gray-400 font-medium">
                                        {course.code}
                                    </span>
                                    {course.status !== 'published' && (
                                        <span className="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 px-3 py-1 rounded-full text-sm font-medium">
                                            {course.status}
                                        </span>
                                    )}
                                </div>
                                
                                {canEdit && (
                                    <Link
                                        href={route('courses.edit', course.id)}
                                        className="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium"
                                    >
                                        ✏️ Edit Course
                                    </Link>
                                )}
                            </div>
                            
                            <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                {course.title}
                            </h1>
                            
                            <p className="text-gray-600 dark:text-gray-300 mb-6 text-lg leading-relaxed">
                                {course.description}
                            </p>
                            
                            {/* Course Stats */}
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div className="text-2xl font-bold text-blue-600">{course.lessons.length}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-300">Lessons</div>
                                </div>
                                <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div className="text-2xl font-bold text-green-600">{course.quizzes.length}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-300">Quizzes</div>
                                </div>
                                <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div className="text-2xl font-bold text-purple-600">{course.assignments.length}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-300">Assignments</div>
                                </div>
                                <div className="text-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div className="text-2xl font-bold text-orange-600">{course.duration_weeks}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-300">Weeks</div>
                                </div>
                            </div>
                            
                            {/* Teacher Info */}
                            <div className="flex items-center space-x-4 mb-6">
                                <div className="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                    <span className="text-xl">👨‍🏫</span>
                                </div>
                                <div>
                                    <div className="font-semibold text-gray-900 dark:text-white">{course.teacher.name}</div>
                                    {course.teacher.subject_specialization && (
                                        <div className="text-sm text-gray-600 dark:text-gray-300">{course.teacher.subject_specialization}</div>
                                    )}
                                </div>
                            </div>
                            
                            {/* Enrollment Actions */}
                            {user && user.role === 'student' && (
                                <div>
                                    {enrollment ? (
                                        <div className="flex items-center space-x-4">
                                            <span className="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-4 py-2 rounded-lg font-medium">
                                                ✅ Enrolled
                                            </span>
                                            {enrollment.final_grade && (
                                                <span className="text-gray-600 dark:text-gray-300">
                                                    Current Grade: {enrollment.final_grade}%
                                                </span>
                                            )}
                                        </div>
                                    ) : (
                                        <button
                                            onClick={handleEnroll}
                                            className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-3 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium"
                                        >
                                            🎓 Enroll in Course
                                        </button>
                                    )}
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Lessons */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                                📚 Course Lessons
                            </h2>
                            
                            {course.lessons.length > 0 ? (
                                <div className="space-y-3">
                                    {course.lessons.map((lesson, index) => (
                                        <div key={lesson.id} className="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <div className="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                                <span className="text-blue-600 dark:text-blue-400 font-semibold">{index + 1}</span>
                                            </div>
                                            <div className="flex-1">
                                                <h3 className="font-semibold text-gray-900 dark:text-white">{lesson.title}</h3>
                                                {lesson.description && (
                                                    <p className="text-sm text-gray-600 dark:text-gray-300 mt-1">{lesson.description}</p>
                                                )}
                                                <div className="flex items-center space-x-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    <span>⏱️ {lesson.estimated_duration} min</span>
                                                    {!lesson.is_published && (
                                                        <span className="bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 px-2 py-1 rounded">
                                                            Draft
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                            {lesson.is_published && enrollment && (
                                                <button className="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm">
                                                    Start Lesson
                                                </button>
                                            )}
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-8 text-gray-500 dark:text-gray-400">
                                    📝 No lessons available yet
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Quizzes */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                ✅ Quizzes
                            </h3>
                            
                            {course.quizzes.length > 0 ? (
                                <div className="space-y-3">
                                    {course.quizzes.slice(0, 5).map((quiz) => (
                                        <div key={quiz.id} className="border-l-4 border-green-400 pl-3 py-2">
                                            <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                {quiz.title}
                                            </h4>
                                            <div className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {quiz.time_limit && <span>⏱️ {quiz.time_limit} min</span>}
                                                <span className="ml-2">🎯 {quiz.passing_score}% to pass</span>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-600 dark:text-gray-300 text-sm">No quizzes available</p>
                            )}
                        </div>

                        {/* Assignments */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                📝 Assignments
                            </h3>
                            
                            {course.assignments.length > 0 ? (
                                <div className="space-y-3">
                                    {course.assignments.slice(0, 5).map((assignment) => (
                                        <div key={assignment.id} className="border-l-4 border-purple-400 pl-3 py-2">
                                            <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                {assignment.title}
                                            </h4>
                                            <div className="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                <span>📊 {assignment.max_points} points</span>
                                                {assignment.due_date && (
                                                    <span className="ml-2">📅 Due: {new Date(assignment.due_date).toLocaleDateString()}</span>
                                                )}
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-600 dark:text-gray-300 text-sm">No assignments available</p>
                            )}
                        </div>

                        {/* Quick Actions */}
                        {enrollment && (
                            <div className="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                                <h3 className="text-lg font-bold mb-4">🚀 Quick Actions</h3>
                                <div className="space-y-2">
                                    <button className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                        💬 Join Discussion
                                    </button>
                                    <button className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                        📊 View Progress
                                    </button>
                                    <button className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                        💡 Ask Question
                                    </button>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppShell>
    );
}