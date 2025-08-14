import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface Student {
    id: number;
    name: string;
    email: string;
}

interface Submission {
    id: number;
    content?: string;
    status: string;
    submitted_at?: string;
    student: Student;
}

interface Course {
    id: number;
    title: string;
    code: string;
    status: string;
    enrollments: Array<{
        id: number;
        student: Student;
    }>;
    lessons: Array<{
        id: number;
        title: string;
    }>;
    quizzes: Array<{
        id: number;
        title: string;
    }>;
    assignments: Array<{
        id: number;
        title: string;
        submissions: Submission[];
    }>;
}

interface Props {
    courses: Course[];
    recent_submissions: Submission[];
    [key: string]: unknown;
}

export default function TeacherDashboard({ courses, recent_submissions }: Props) {
    const totalStudents = courses.reduce((sum, course) => sum + course.enrollments.length, 0);
    const totalLessons = courses.reduce((sum, course) => sum + course.lessons.length, 0);
    const pendingSubmissions = recent_submissions.filter(sub => sub.status === 'submitted').length;

    return (
        <AppShell>
            <Head title="Teacher Dashboard - ScienceHub LMS" />
            
            <div className="p-6 max-w-7xl mx-auto">
                {/* Welcome Section */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        👩‍🏫 Teacher Dashboard
                    </h1>
                    <p className="text-gray-600 dark:text-gray-300">
                        Manage your courses and track student progress
                    </p>
                </div>

                {/* Stats Overview */}
                <div className="grid md:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-300">My Courses</p>
                                <p className="text-3xl font-bold text-blue-600">{courses.length}</p>
                            </div>
                            <span className="text-3xl">📚</span>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-300">Total Students</p>
                                <p className="text-3xl font-bold text-green-600">{totalStudents}</p>
                            </div>
                            <span className="text-3xl">🎓</span>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-300">Lessons Created</p>
                                <p className="text-3xl font-bold text-purple-600">{totalLessons}</p>
                            </div>
                            <span className="text-3xl">📖</span>
                        </div>
                    </div>
                    
                    <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 dark:text-gray-300">Pending Reviews</p>
                                <p className="text-3xl font-bold text-orange-600">{pendingSubmissions}</p>
                            </div>
                            <span className="text-3xl">✏️</span>
                        </div>
                    </div>
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
                                    href={route('courses.create')}
                                    className="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors font-medium"
                                >
                                    ➕ New Course
                                </Link>
                            </div>
                            
                            {courses.length > 0 ? (
                                <div className="space-y-4">
                                    {courses.map((course) => (
                                        <div key={course.id} className="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                            <div className="flex items-center justify-between">
                                                <div className="flex-1">
                                                    <div className="flex items-center space-x-3 mb-2">
                                                        <h3 className="font-bold text-gray-900 dark:text-white">
                                                            {course.title}
                                                        </h3>
                                                        <span className="text-sm text-gray-500 dark:text-gray-400">
                                                            {course.code}
                                                        </span>
                                                        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                                            course.status === 'published' 
                                                                ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300'
                                                                : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300'
                                                        }`}>
                                                            {course.status}
                                                        </span>
                                                    </div>
                                                    <div className="grid grid-cols-3 gap-4 text-sm text-gray-600 dark:text-gray-300">
                                                        <span>👥 {course.enrollments.length} students</span>
                                                        <span>📖 {course.lessons.length} lessons</span>
                                                        <span>✅ {course.quizzes.length} quizzes</span>
                                                    </div>
                                                </div>
                                                
                                                <div className="flex space-x-2">
                                                    <Link
                                                        href={route('courses.show', course.id)}
                                                        className="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium"
                                                    >
                                                        View
                                                    </Link>
                                                    <Link
                                                        href={route('courses.edit', course.id)}
                                                        className="text-gray-600 dark:text-gray-400 hover:underline text-sm font-medium"
                                                    >
                                                        Edit
                                                    </Link>
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
                                        Create your first course to start teaching
                                    </p>
                                    <Link
                                        href={route('courses.create')}
                                        className="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors font-medium"
                                    >
                                        🚀 Create Course
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Recent Submissions */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                📝 Recent Submissions
                            </h3>
                            
                            {recent_submissions.length > 0 ? (
                                <div className="space-y-3">
                                    {recent_submissions.slice(0, 8).map((submission) => (
                                        <div key={submission.id} className={`border-l-4 pl-3 py-2 ${
                                            submission.status === 'submitted' 
                                                ? 'border-orange-400' 
                                                : 'border-green-400'
                                        }`}>
                                            <h4 className="font-medium text-gray-900 dark:text-white text-sm">
                                                {submission.student.name}
                                            </h4>
                                            <p className="text-xs text-gray-600 dark:text-gray-300">
                                                {submission.submitted_at 
                                                    ? new Date(submission.submitted_at).toLocaleDateString()
                                                    : 'In progress'
                                                }
                                            </p>
                                            <p className={`text-xs font-medium ${
                                                submission.status === 'submitted' 
                                                    ? 'text-orange-600 dark:text-orange-400' 
                                                    : 'text-green-600 dark:text-green-400'
                                            }`}>
                                                {submission.status === 'submitted' ? 'Needs Review' : 'Graded'}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            ) : (
                                <p className="text-gray-600 dark:text-gray-300 text-sm">
                                    No recent submissions
                                </p>
                            )}
                        </div>

                        {/* Quick Actions */}
                        <div className="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white shadow-lg">
                            <h3 className="text-lg font-bold mb-4">🚀 Quick Actions</h3>
                            <div className="space-y-3">
                                <Link
                                    href={route('courses.create')}
                                    className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm block text-center"
                                >
                                    ➕ Create New Course
                                </Link>
                                <button className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                    📊 View Analytics
                                </button>
                                <button className="w-full bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                    💬 Message Students
                                </button>
                            </div>
                        </div>

                        {/* Teaching Tips */}
                        <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                💡 Teaching Tips
                            </h3>
                            <div className="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                <p>📝 Create engaging lesson content with multimedia elements</p>
                                <p>🎯 Use interactive quizzes to reinforce learning</p>
                                <p>💬 Encourage student participation in discussions</p>
                                <p>📊 Monitor student progress regularly</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}