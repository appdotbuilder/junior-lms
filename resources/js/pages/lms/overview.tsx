import React from 'react';
import { Head, Link } from '@inertiajs/react';

interface LmsStats {
    total_courses: number;
    total_students: number;
    total_teachers: number;
    total_quizzes: number;
}

interface Course {
    id: number;
    title: string;
    description: string;
    grade_level: string;
    subject: string;
    cover_image?: string;
    teacher: {
        name: string;
    };
}

interface Props {
    stats: LmsStats;
    featured_courses: Course[];
    [key: string]: unknown;
}

export default function LmsOverview({ stats, featured_courses }: Props) {
    return (
        <>
            <Head title="ScienceHub LMS - Overview" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
                    <div className="container mx-auto px-4 py-6">
                        <div className="flex items-center justify-between">
                            <Link href="/" className="flex items-center space-x-2">
                                <div className="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                    🔬
                                </div>
                                <span className="text-2xl font-bold text-gray-900 dark:text-white">ScienceHub LMS</span>
                            </Link>
                            
                            <div className="flex items-center space-x-4">
                                <Link
                                    href={route('login')}
                                    className="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors px-4 py-2 rounded-md hover:bg-white/50 dark:hover:bg-gray-700/50"
                                >
                                    Login
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-medium"
                                >
                                    Get Started
                                </Link>
                            </div>
                        </div>
                    </div>
                </header>

                {/* Main Content */}
                <main className="container mx-auto px-4 py-12">
                    {/* Stats Section */}
                    <div className="text-center mb-16">
                        <h1 className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                            🎓 Welcome to ScienceHub LMS
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-12 max-w-3xl mx-auto">
                            Join our thriving community of science learners and educators
                        </p>
                        
                        <div className="grid md:grid-cols-4 gap-6 mb-12">
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                                <div className="text-3xl mb-2">📚</div>
                                <div className="text-3xl font-bold text-blue-600 mb-2">{stats.total_courses}</div>
                                <div className="text-gray-600 dark:text-gray-300">Active Courses</div>
                            </div>
                            
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                                <div className="text-3xl mb-2">🎓</div>
                                <div className="text-3xl font-bold text-green-600 mb-2">{stats.total_students}</div>
                                <div className="text-gray-600 dark:text-gray-300">Students</div>
                            </div>
                            
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                                <div className="text-3xl mb-2">👩‍🏫</div>
                                <div className="text-3xl font-bold text-purple-600 mb-2">{stats.total_teachers}</div>
                                <div className="text-gray-600 dark:text-gray-300">Teachers</div>
                            </div>
                            
                            <div className="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
                                <div className="text-3xl mb-2">✅</div>
                                <div className="text-3xl font-bold text-orange-600 mb-2">{stats.total_quizzes}</div>
                                <div className="text-gray-600 dark:text-gray-300">Interactive Quizzes</div>
                            </div>
                        </div>
                    </div>

                    {/* Featured Courses */}
                    <div className="mb-16">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                🌟 Featured Science Courses
                            </h2>
                            <p className="text-lg text-gray-600 dark:text-gray-300">
                                Discover engaging science courses for grades 7-9
                            </p>
                        </div>
                        
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {featured_courses.map((course) => (
                                <div key={course.id} className="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                    <div className="h-48 bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center">
                                        {course.cover_image ? (
                                            <img src={course.cover_image} alt={course.title} className="w-full h-full object-cover" />
                                        ) : (
                                            <span className="text-6xl">🧪</span>
                                        )}
                                    </div>
                                    
                                    <div className="p-6">
                                        <div className="flex items-center justify-between mb-3">
                                            <span className="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                                {course.grade_level} Grade
                                            </span>
                                            <span className="text-sm text-gray-500 dark:text-gray-400">
                                                {course.subject}
                                            </span>
                                        </div>
                                        
                                        <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                            {course.title}
                                        </h3>
                                        
                                        <p className="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                            {course.description}
                                        </p>
                                        
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
                        
                        <div className="text-center mt-12">
                            <Link
                                href={route('courses.index')}
                                className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 font-semibold text-lg"
                            >
                                🔍 Explore All Courses
                            </Link>
                        </div>
                    </div>

                    {/* Call to Action */}
                    <div className="text-center bg-gradient-to-r from-blue-500 to-indigo-600 rounded-3xl p-12 text-white">
                        <h2 className="text-3xl font-bold mb-4">🚀 Ready to Start Learning?</h2>
                        <p className="text-xl mb-8 opacity-90">
                            Join our community and access interactive science courses designed for junior high students
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link
                                href={route('register')}
                                className="bg-white text-blue-600 px-8 py-4 rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 font-semibold text-lg shadow-lg"
                            >
                                🎓 Sign Up Now
                            </Link>
                            <Link
                                href={route('login')}
                                className="border-2 border-white text-white px-8 py-4 rounded-xl hover:bg-white/10 transition-all duration-200 font-semibold text-lg"
                            >
                                🔑 Already Have Account?
                            </Link>
                        </div>
                    </div>
                </main>
            </div>
        </>
    );
}