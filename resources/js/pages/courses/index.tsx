import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import type { SharedData } from '@/types';

interface Course {
    id: number;
    title: string;
    code: string;
    description: string;
    grade_level: string;
    subject: string;
    cover_image: string | null;
    status: string;
    duration_weeks: number;
    teacher: {
        id: number;
        name: string;
    };
    enrollments: Array<{
        id: number;
        student_id: number;
    }>;
    lessons: Array<{
        id: number;
        title: string;
    }>;
}

interface PaginationData {
    data: Course[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

interface Props {
    courses: PaginationData;
    [key: string]: unknown;
}

export default function CoursesIndex({ courses }: Props) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    const canCreateCourse = user && (user.role === 'teacher' || user.role === 'administrator');

    return (
        <AppShell>
            <Head title="Courses - ScienceHub LMS" />
            
            <div className="p-6 max-w-7xl mx-auto">
                {/* Header */}
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                            📚 Science Courses
                        </h1>
                        <p className="text-gray-600 dark:text-gray-300">
                            Explore interactive science courses for grades 7-9
                        </p>
                    </div>
                    
                    {canCreateCourse && (
                        <Link
                            href={route('courses.create')}
                            className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium"
                        >
                            ➕ Create Course
                        </Link>
                    )}
                </div>

                {/* Course Grid */}
                {courses.data.length > 0 ? (
                    <>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                            {courses.data.map((course) => (
                                <div key={course.id} className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    {/* Course Image */}
                                    <div className="h-48 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center relative">
                                        {course.cover_image ? (
                                            <img src={course.cover_image} alt={course.title} className="w-full h-full object-cover" />
                                        ) : (
                                            <span className="text-6xl">🧪</span>
                                        )}
                                        
                                        {/* Status Badge */}
                                        {course.status !== 'published' && (
                                            <div className="absolute top-2 left-2">
                                                <span className="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-medium uppercase">
                                                    {course.status}
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                    
                                    {/* Course Info */}
                                    <div className="p-6">
                                        <div className="flex items-center justify-between mb-3">
                                            <span className="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                                {course.grade_level} Grade
                                            </span>
                                            <span className="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                                {course.code}
                                            </span>
                                        </div>
                                        
                                        <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                            {course.title}
                                        </h3>
                                        
                                        <p className="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3">
                                            {course.description}
                                        </p>
                                        
                                        {/* Course Stats */}
                                        <div className="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                            <span>📖 {course.lessons.length} lessons</span>
                                            <span>👥 {course.enrollments.length} students</span>
                                            <span>⏱️ {course.duration_weeks}w</span>
                                        </div>
                                        
                                        {/* Teacher */}
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center space-x-2">
                                                <span className="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-sm">
                                                    👨‍🏫
                                                </span>
                                                <span className="text-sm text-gray-600 dark:text-gray-300">
                                                    {course.teacher.name}
                                                </span>
                                            </div>
                                            
                                            <Link
                                                href={route('courses.show', course.id)}
                                                className="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm font-medium"
                                            >
                                                View Course
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Pagination */}
                        {courses.last_page > 1 && (
                            <div className="flex justify-center">
                                <div className="flex space-x-2">
                                    {Array.from({ length: courses.last_page }, (_, i) => i + 1).map((page) => (
                                        <Link
                                            key={page}
                                            href={route('courses.index', { page })}
                                            className={`px-4 py-2 rounded-lg transition-colors ${
                                                page === courses.current_page
                                                    ? 'bg-blue-500 text-white'
                                                    : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600'
                                            }`}
                                        >
                                            {page}
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        )}
                    </>
                ) : (
                    /* Empty State */
                    <div className="text-center py-16">
                        <div className="text-8xl mb-6">📚</div>
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                            No courses available
                        </h2>
                        <p className="text-gray-600 dark:text-gray-300 mb-8 max-w-md mx-auto">
                            {canCreateCourse 
                                ? "Start creating engaging science courses for your students"
                                : "Check back later for new science courses"
                            }
                        </p>
                        {canCreateCourse && (
                            <Link
                                href={route('courses.create')}
                                className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-semibold text-lg"
                            >
                                ➕ Create Your First Course
                            </Link>
                        )}
                    </div>
                )}
            </div>
        </AppShell>
    );
}