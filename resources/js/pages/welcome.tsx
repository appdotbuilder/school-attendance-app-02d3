import React from 'react';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="School Attendance System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col items-center bg-gradient-to-br from-blue-50 to-indigo-100 p-6 text-gray-800 lg:justify-center lg:p-8 dark:from-gray-900 dark:to-gray-800 dark:text-gray-200">
                <header className="mb-8 w-full max-w-6xl text-sm">
                    <nav className="flex items-center justify-end gap-4">
                        {auth.user ? (
                            <Link
                                href={route('dashboard')}
                                className="inline-block rounded-lg border border-blue-200 bg-white px-6 py-2.5 text-sm font-medium text-blue-700 shadow-sm hover:bg-blue-50 dark:border-blue-700 dark:bg-gray-800 dark:text-blue-300 dark:hover:bg-gray-700"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-lg px-6 py-2.5 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400"
                                >
                                    Log in
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-lg border border-blue-200 bg-white px-6 py-2.5 text-sm font-medium text-blue-700 shadow-sm hover:bg-blue-50 dark:border-blue-700 dark:bg-gray-800 dark:text-blue-300 dark:hover:bg-gray-700"
                                >
                                    Register
                                </Link>
                            </>
                        )}
                    </nav>
                </header>

                <main className="flex w-full max-w-6xl flex-col items-center">
                    {/* Hero Section */}
                    <div className="text-center mb-16">
                        <div className="mb-6">
                            <span className="text-6xl">📚</span>
                        </div>
                        <h1 className="mb-6 text-4xl font-bold text-gray-900 dark:text-white lg:text-6xl">
                            School Attendance System
                        </h1>
                        <p className="mb-8 text-xl text-gray-600 dark:text-gray-400 lg:text-2xl max-w-3xl">
                            Comprehensive web-based attendance management for schools. 
                            Track student attendance, manage leave requests, and generate detailed reports.
                        </p>
                        
                        {!auth.user && (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="inline-block rounded-xl bg-blue-600 px-8 py-4 text-lg font-semibold text-white shadow-lg hover:bg-blue-700 transform hover:scale-105 transition-all duration-200"
                                >
                                    Get Started 🚀
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="inline-block rounded-xl border-2 border-blue-600 px-8 py-4 text-lg font-semibold text-blue-600 hover:bg-blue-600 hover:text-white transition-all duration-200"
                                >
                                    Sign In
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 w-full">
                        {/* Feature 1 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">👥</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                User Management
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Complete role-based system for Admin, Teachers, Students, and Parents with appropriate access controls.
                            </p>
                        </div>

                        {/* Feature 2 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">✅</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                Attendance Tracking
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Record student attendance per session or daily with status tracking (Present, Absent, Late, Excused, Sick).
                            </p>
                        </div>

                        {/* Feature 3 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">📋</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                Leave Management
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Submit and approve leave requests with document attachments and notification system.
                            </p>
                        </div>

                        {/* Feature 4 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                Reports & Analytics
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Generate comprehensive attendance reports with filtering by class, subject, or student. Export functionality included.
                            </p>
                        </div>

                        {/* Feature 5 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">📅</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                Schedule Management
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Manage class schedules, academic calendar, and subject assignments with room allocation.
                            </p>
                        </div>

                        {/* Feature 6 */}
                        <div className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 dark:bg-gray-800">
                            <div className="text-4xl mb-4">🔔</div>
                            <h3 className="text-xl font-semibold mb-3 text-gray-900 dark:text-white">
                                Notifications
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400">
                                Automated notifications for absence alerts to parents and leave request status updates.
                            </p>
                        </div>
                    </div>

                    {/* User Roles Section */}
                    <div className="w-full mb-16">
                        <h2 className="text-3xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                            Built for Every School Role 🎯
                        </h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">👨‍💼 Admin & Operators</h4>
                                <p className="text-purple-100">Full system control, user management, and comprehensive reporting.</p>
                            </div>
                            <div className="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">👨‍🏫 Teachers & Principals</h4>
                                <p className="text-blue-100">Record attendance, approve leave requests, and monitor class performance.</p>
                            </div>
                            <div className="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">👨‍🎓 Students</h4>
                                <p className="text-green-100">View attendance history and submit leave requests easily.</p>
                            </div>
                            <div className="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">👨‍👩‍👧‍👦 Parents</h4>
                                <p className="text-orange-100">Monitor child's attendance and receive instant notifications.</p>
                            </div>
                            <div className="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">🏫 School Management</h4>
                                <p className="text-indigo-100">Access analytics and school-wide attendance insights.</p>
                            </div>
                            <div className="bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-xl p-6">
                                <h4 className="font-semibold text-lg mb-2">📚 Class Management</h4>
                                <p className="text-pink-100">Organize classes, subjects, and academic schedules efficiently.</p>
                            </div>
                        </div>
                    </div>

                    {/* Stats Preview */}
                    <div className="w-full bg-white rounded-2xl p-8 shadow-lg mb-16 dark:bg-gray-800">
                        <h2 className="text-2xl font-bold text-center mb-8 text-gray-900 dark:text-white">
                            System Overview 📈
                        </h2>
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <div className="text-center">
                                <div className="text-3xl font-bold text-blue-600 mb-2">100%</div>
                                <div className="text-gray-600 dark:text-gray-400">Attendance Rate</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-green-600 mb-2">500+</div>
                                <div className="text-gray-600 dark:text-gray-400">Students</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-purple-600 mb-2">50+</div>
                                <div className="text-gray-600 dark:text-gray-400">Teachers</div>
                            </div>
                            <div className="text-center">
                                <div className="text-3xl font-bold text-orange-600 mb-2">24/7</div>
                                <div className="text-gray-600 dark:text-gray-400">System Uptime</div>
                            </div>
                        </div>
                    </div>

                    {/* Call to Action */}
                    {!auth.user && (
                        <div className="text-center bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl p-12 w-full">
                            <h2 className="text-3xl font-bold mb-4">Ready to Get Started? 🌟</h2>
                            <p className="text-xl mb-8 text-blue-100">
                                Join thousands of schools already using our attendance system.
                            </p>
                            <Link
                                href={route('register')}
                                className="inline-block rounded-xl bg-white text-blue-600 px-8 py-4 text-lg font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200"
                            >
                                Start Free Trial 🚀
                            </Link>
                        </div>
                    )}
                </main>

                <footer className="mt-16 text-center text-sm text-gray-600 dark:text-gray-400">
                    <p>Built with ❤️ for modern schools • Secure • Scalable • User-friendly</p>
                </footer>
            </div>
        </>
    );
}