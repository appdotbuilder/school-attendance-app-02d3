import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';

interface AttendanceStats {
    total_students: number;
    present_today: number;
    absent_today: number;
    late_today: number;
}

interface AttendanceRecord {
    id: number;
    student: {
        id: number;
        name: string;
        nisn: string;
    };
    class: {
        id: number;
        name: string;
        grade: string;
    };
    subject?: {
        id: number;
        name: string;
        code: string;
    };
    teacher: {
        id: number;
        name: string;
    };
    date: string;
    time?: string;
    status: 'present' | 'absent' | 'late' | 'excused' | 'sick';
    session: string;
    notes?: string;
}

interface ClassToday {
    id: number;
    name: string;
    grade: string;
    homeroom_teacher?: string;
    total_students: number;
    present_today: number;
    absent_today: number;
    attendance_rate: number;
}

interface Props {
    stats: AttendanceStats;
    recent_attendances: AttendanceRecord[];
    classes_today: ClassToday[];
    user_role: string;
    [key: string]: unknown;
}

const statusColors = {
    present: 'bg-green-100 text-green-800',
    absent: 'bg-red-100 text-red-800',
    late: 'bg-yellow-100 text-yellow-800',
    excused: 'bg-blue-100 text-blue-800',
    sick: 'bg-purple-100 text-purple-800',
};

const statusIcons = {
    present: '✅',
    absent: '❌',
    late: '⏰',
    excused: '📝',
    sick: '🏥',
};

export default function AttendanceDashboard({ stats, recent_attendances, classes_today }: Props) {
    return (
        <AppShell>
            <Head title="Attendance Dashboard" />
            
            <div className="p-6 space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                            📚 Attendance Dashboard
                        </h1>
                        <p className="text-gray-600 dark:text-gray-400 mt-1">
                            Welcome back! Here's today's attendance overview.
                        </p>
                    </div>
                    <div className="text-sm text-gray-500 dark:text-gray-400">
                        {new Date().toLocaleDateString('en-US', { 
                            weekday: 'long', 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}
                    </div>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Total Students</p>
                                <p className="text-3xl font-bold text-gray-900 dark:text-white">{stats.total_students}</p>
                            </div>
                            <div className="text-4xl">👥</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Present Today</p>
                                <p className="text-3xl font-bold text-green-600">{stats.present_today}</p>
                            </div>
                            <div className="text-4xl">✅</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Absent Today</p>
                                <p className="text-3xl font-bold text-red-600">{stats.absent_today}</p>
                            </div>
                            <div className="text-4xl">❌</div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm font-medium text-gray-600 dark:text-gray-400">Late Today</p>
                                <p className="text-3xl font-bold text-yellow-600">{stats.late_today}</p>
                            </div>
                            <div className="text-4xl">⏰</div>
                        </div>
                    </div>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Classes Today */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between mb-6">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                📝 Today's Classes
                            </h2>
                            <span className="text-sm text-gray-500 dark:text-gray-400">
                                {classes_today.length} classes
                            </span>
                        </div>

                        <div className="space-y-4 max-h-96 overflow-y-auto">
                            {classes_today.length > 0 ? (
                                classes_today.map((classItem) => (
                                    <div key={classItem.id} className="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2 mb-1">
                                                <h3 className="font-medium text-gray-900 dark:text-white">
                                                    {classItem.name}
                                                </h3>
                                                <span className="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">
                                                    {classItem.grade}
                                                </span>
                                            </div>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                Teacher: {classItem.homeroom_teacher || 'Not assigned'}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <div className="text-lg font-semibold text-gray-900 dark:text-white">
                                                {classItem.attendance_rate}%
                                            </div>
                                            <div className="text-xs text-gray-500 dark:text-gray-400">
                                                {classItem.present_today}/{classItem.total_students}
                                            </div>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <div className="text-4xl mb-2">📚</div>
                                    <p>No classes found for today</p>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* Recent Attendance */}
                    <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div className="flex items-center justify-between mb-6">
                            <h2 className="text-xl font-semibold text-gray-900 dark:text-white">
                                🕒 Recent Activity
                            </h2>
                            <span className="text-sm text-gray-500 dark:text-gray-400">
                                Latest updates
                            </span>
                        </div>

                        <div className="space-y-4 max-h-96 overflow-y-auto">
                            {recent_attendances.length > 0 ? (
                                recent_attendances.map((record) => (
                                    <div key={record.id} className="flex items-start gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg">
                                        <div className="text-2xl">
                                            {statusIcons[record.status]}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <div className="flex items-center gap-2 mb-1">
                                                <p className="font-medium text-gray-900 dark:text-white truncate">
                                                    {record.student.name}
                                                </p>
                                                <span className={`text-xs px-2 py-1 rounded-full ${statusColors[record.status]}`}>
                                                    {record.status}
                                                </span>
                                            </div>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                {record.class.name} • {record.subject?.name || 'General'}
                                            </p>
                                            <p className="text-xs text-gray-500 dark:text-gray-400">
                                                {new Date(record.date).toLocaleDateString()} {record.time && `at ${record.time}`}
                                            </p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500 dark:text-gray-400">
                                    <div className="text-4xl mb-2">📋</div>
                                    <p>No recent attendance records</p>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
                    <h2 className="text-xl font-semibold mb-4">🚀 Quick Actions</h2>
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a 
                            href="/attendance/create" 
                            className="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors"
                        >
                            <div className="text-2xl mb-2">✏️</div>
                            <div className="font-medium">Record Attendance</div>
                            <div className="text-sm opacity-90">Mark students present/absent</div>
                        </a>
                        <a 
                            href="/students" 
                            className="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors"
                        >
                            <div className="text-2xl mb-2">👨‍🎓</div>
                            <div className="font-medium">Manage Students</div>
                            <div className="text-sm opacity-90">Add or edit student information</div>
                        </a>
                        <a 
                            href="/settings" 
                            className="bg-white/20 hover:bg-white/30 rounded-lg p-4 text-center transition-colors"
                        >
                            <div className="text-2xl mb-2">⚙️</div>
                            <div className="font-medium">Settings</div>
                            <div className="text-sm opacity-90">Configure system settings</div>
                        </a>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}