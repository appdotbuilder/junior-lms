import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Enrollment {
    id: number;
    status: string;
    final_grade: number | null;
    enrolled_at: string;
    course: {
        id: number;
        title: string;
        description: string;
        grade_level: string;
        cover_image: string | null;
        teacher: {
            name: string;
        };
        lessons: Array<{
            id: number;
            title: string;
            is_published: boolean;
        }>;
    };
}

interface Assignment {
    id: number;
    title: string;
    due_date: string;
    max_points: number;
    course: {
        title: string;
    };
}

interface Quiz {
    id: number;
    title: string;
    available_until: string;
    passing_score: number;
    course: {
        title: string;
    };
}

interface Props {
    enrollments: Enrollment[];
    recent_assignments: Assignment[];
    recent_quizzes: Quiz[];
    [key: string]: unknown;
}

export default function StudentDashboard({ enrollments, recent_assignments, recent_quizzes }: Props) {
    return (
        <AppShell>
            <Head title="Student Dashboard - ScienceHub LMS" />
            
            <div className="p-6 max-w-7xl mx-auto">
                {/* Welcome Section */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        🎓 Welcome Back, Student!
                    </h1>
                    <p className="text-gray-600 dark:text-gray-300">
                        Continue your science learning journey
                    </p>
                </div>

                <div className="grid lg:grid-cols-3 gap-8">
                    {/* Main Content */}
                    <div className="lg:col-span-2 space-y-8">
                        {/* My Courses */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <div className="flex items-center justify-between mb-6">
                                <h2 className="text-2xl font-bold text-gray-900 dark:text-white">
                                    📚 My Courses
                                </h2>
                                <Link
                                    href={route('courses.index')}
                                    className="text-blue-600 dark:text-blue-400 hover:underline"
                                >
                                    Browse All Courses
                                </Link>
                            </div>
                            
                            {enrollments.length > 0 ? (
                                <div className="grid md:grid-cols-2 gap-4">
                                    {enrollments.map((enrollment) => (
                                        <div key={enrollment.id} className="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div className="flex items-start space-x-4">
                                                <div className="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    {enrollment.course.cover_image ? (
                                                        <img src={enrollment.course.cover_image} alt={enrollment.course.title} className="w-full h-full object-cover rounded-lg" />
                                                    ) : (
                                                        <span className="text-2xl">🧪</span>
                                                    )}
                                                </div>
                                                
                                                <div className="flex-1 min-w-0">
                                                    <h3 className="font-bold text-gray-900 dark:text-white truncate">
                                                        {enrollment.course.title}
                                                    </h3>
                                                    <p className="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                                        {enrollment.course.teacher.name}
                                                    </p>
                                                    <div className="flex items-center justify-between">
                                                        <span className="bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 px-2 py-1 rounded text-xs font-medium">
                                                            {enrollment.course.grade_level} Grade
                                                        </span>
                                                        {enrollment.final_grade && (
                                                            <span className="text-sm font-medium text-gray-900 dark:text-white">
                                                                Grade: {enrollment.final_grade}%
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div className="mt-2">
                                                        <Link
                                                            href={route('courses.show', enrollment.course.id)}
                                                            className="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium"
                                                        >
                                                            Continue Learning →
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <div className="text-center py-12">
                                    <div className="text-6xl mb-4">📚</div>
                                    <h3 className="text-xl font-medium text-gray-900 dark:text-white mb-2">
                                        No courses yet
                                    </h3>
                                    <p className="text-gray-600 dark:text-gray-300 mb-6">
                                        Start your science learning journey by enrolling in a course
                                    </p>
                                    <Link
                                        href={route('courses.index')}
                                        className="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium"
                                    >
                                        🔍 Browse Courses
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Upcoming Assignments */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                📝 Upcoming Assignments
                            </h3>
                            
                            {recent_assignments.length > 0 ? (
                                <div className="space-y-3">
                                    {recent_assignments.slice(0, 5).map((assignment) => (
                                        <div key={assignment.id} className="border-l-4 border-orange-400 pl-3 py-2">
                                            <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                {assignment.title}
                                            </h4>
                                            <p className="text-xs text-gray-600 dark:text-gray-300">
                                                {assignment.course.title}
                                            </p>
                                            <p className="text-xs text-orange-600 dark:text-orange-400">
                                                Due: {new Date(assignment.due_date).toLocaleDateString()}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    No upcoming assignments
                                </p>
                            )}
                        </div>

                        {/* Upcoming Quizzes */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                ✅ Upcoming Quizzes
                            </h3>
                            
                            {recent_quizzes.length > 0 ? (
                                <div className="space-y-3">
                                    {recent_quizzes.slice(0, 5).map((quiz) => (
                                        <div key={quiz.id} className="border-l-4 border-blue-400 pl-3 py-2">
                                            <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                {quiz.title}
                                            </h4>
                                            <p className="text-xs text-gray-600 dark:text-gray-300">
                                                {quiz.course.title}
                                            </p>
                                            <p className="text-xs text-blue-600 dark:text-blue-400">
                                                Until: {new Date(quiz.available_until).toLocaleDateString()}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    No upcoming quizzes
                                </p>
                            )}
                        </div>

                        {/* Quick Stats */}
                        <div className="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                            <h3 className="text-lg font-bold mb-4">📊 Your Progress</h3>
                            <div className="space-y-3">
                                <div className="flex justify-between">
                                    <span>Enrolled Courses</span>
                                    <span className="font-bold">{enrollments.length}</span>
                                </div>
                                <div className="flex justify-between">
                                    <span>Pending Assignments</span>
                                    <span className="font-bold">{recent_assignments.length}</span>
                                </div>
                                <div className="flex justify-between">
                                    <span>Available Quizzes</span>
                                    <span className="font-bold">{recent_quizzes.length}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}