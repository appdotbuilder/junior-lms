import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="ScienceHub LMS - Learn Science the Smart Way">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Navigation */}
                <header className="container mx-auto px-4 py-6">
                    <nav className="flex items-center justify-between">
                        <div className="flex items-center space-x-2">
                            <div className="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                🔬
                            </div>
                            <span className="text-2xl font-bold text-gray-900 dark:text-white">ScienceHub LMS</span>
                        </div>
                        
                        <div className="flex items-center space-x-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 font-medium"
                                >
                                    📊 Dashboard
                                </Link>
                            ) : (
                                <>
                                    <Link
                                        href={route('login')}
                                        className="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors px-4 py-2 rounded-md hover:bg-white/50 dark:hover:bg-gray-700/50"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 font-medium"
                                    >
                                        Get Started
                                    </Link>
                                </>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="container mx-auto px-4 py-12">
                    <div className="text-center mb-16">
                        <div className="flex justify-center mb-6">
                            <div className="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 rounded-full">
                                <span className="text-4xl">🧪</span>
                            </div>
                        </div>
                        <h1 className="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Learn Science the 
                            <span className="bg-gradient-to-r from-blue-500 to-indigo-600 bg-clip-text text-transparent"> Smart Way</span>
                        </h1>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            🎓 A comprehensive Learning Management System designed specifically for junior high school science education. 
                            Interactive lessons, real-time collaboration, and intelligent progress tracking.
                        </p>
                        
                        {!auth.user && (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                                <Link
                                    href={route('register')}
                                    className="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105 font-semibold text-lg shadow-lg"
                                >
                                    🚀 Start Learning Now
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="border-2 border-blue-500 text-blue-500 dark:text-blue-400 px-8 py-4 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 font-semibold text-lg"
                                >
                                    🔑 Login
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Key Features */}
                    <div className="grid md:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Multi-Role System</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Dedicated dashboards for Students, Teachers, and Administrators with role-specific features and permissions.
                            </p>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">🎯</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Interactive Learning</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Engaging content with videos, interactive quizzes, assignments, and multimedia resources for effective learning.
                            </p>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                            <div className="text-4xl mb-4">📈</div>
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">Progress Tracking</h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Real-time progress monitoring, detailed analytics, and comprehensive grading system for better outcomes.
                            </p>
                        </div>
                    </div>

                    {/* Additional Features */}
                    <div className="bg-white dark:bg-gray-800 rounded-3xl p-12 shadow-xl mb-16">
                        <h2 className="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">🌟 Everything You Need to Excel</h2>
                        
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div className="text-center p-6 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <div className="text-3xl mb-3">📚</div>
                                <h4 className="font-semibold text-gray-900 dark:text-white">Course Management</h4>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                    Structured lessons and materials for 7th-9th grade science
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-green-50 dark:bg-green-900/20 rounded-xl">
                                <div className="text-3xl mb-3">✅</div>
                                <h4 className="font-semibold text-gray-900 dark:text-white">Smart Quizzes</h4>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                    Interactive quizzes with instant feedback and explanations
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-purple-50 dark:bg-purple-900/20 rounded-xl">
                                <div className="text-3xl mb-3">💬</div>
                                <h4 className="font-semibold text-gray-900 dark:text-white">Live Communication</h4>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                    Discussion forums and live chat for collaboration
                                </p>
                            </div>
                            
                            <div className="text-center p-6 bg-orange-50 dark:bg-orange-900/20 rounded-xl">
                                <div className="text-3xl mb-3">📊</div>
                                <h4 className="font-semibold text-gray-900 dark:text-white">Grade Analytics</h4>
                                <p className="text-sm text-gray-600 dark:text-gray-300 mt-2">
                                    Comprehensive grading and progress analytics
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Call to Action */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-blue-500 to-indigo-600 rounded-3xl p-12 text-white">
                            <h2 className="text-3xl font-bold mb-4">🎯 Ready to Transform Science Education?</h2>
                            <p className="text-xl mb-8 opacity-90">
                                Join thousands of students and teachers already using ScienceHub LMS
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="bg-white text-blue-600 px-8 py-4 rounded-xl hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 font-semibold text-lg shadow-lg"
                                >
                                    🎓 Create Account
                                </Link>
                                <button className="border-2 border-white text-white px-8 py-4 rounded-xl hover:bg-white/10 transition-all duration-200 font-semibold text-lg">
                                    📞 Contact Sales
                                </button>
                            </div>
                        </div>
                    )}
                </main>

                {/* Footer */}
                <footer className="container mx-auto px-4 py-8 text-center text-gray-600 dark:text-gray-400">
                    <p className="mb-2">© 2024 ScienceHub LMS. Empowering the next generation of scientists.</p>
                    <p className="text-sm">
                        Built with ❤️ for junior high school science education
                    </p>
                </footer>
            </div>
        </>
    );
}