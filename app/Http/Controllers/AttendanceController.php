<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display the attendance dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get today's statistics
        $today = Carbon::today();
        
        $stats = [
            'total_students' => User::students()->active()->count(),
            'present_today' => Attendance::byDate($today)->present()->count(),
            'absent_today' => Attendance::byDate($today)->absent()->count(),
            'late_today' => Attendance::byDate($today)->where('status', 'late')->count(),
        ];
        
        // Get recent attendance records
        $recentAttendances = Attendance::with(['student', 'class', 'subject', 'teacher'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Get classes with today's attendance summary
        $classesToday = Classes::with(['students.student', 'homeroomTeacher'])
            ->where('is_active', true)
            ->get()
            ->map(function ($class) use ($today) {
                $totalStudents = $class->students()->where('is_active', true)->count();
                $presentToday = Attendance::where('class_id', $class->id)
                    ->byDate($today)
                    ->present()
                    ->count();
                
                return [
                    'id' => $class->id,
                    'name' => $class->name,
                    'grade' => $class->grade,
                    'homeroom_teacher' => $class->homeroomTeacher ? $class->homeroomTeacher->name : null,
                    'total_students' => $totalStudents,
                    'present_today' => $presentToday,
                    'absent_today' => $totalStudents - $presentToday,
                    'attendance_rate' => $totalStudents > 0 ? round(($presentToday / $totalStudents) * 100, 1) : 0,
                ];
            });

        return Inertia::render('attendance/dashboard', [
            'stats' => $stats,
            'recent_attendances' => $recentAttendances,
            'classes_today' => $classesToday,
            'user_role' => $user->role,
        ]);
    }

    /**
     * Record attendance for a class.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'date' => 'required|date',
            'session' => 'required|in:morning,afternoon,full_day',
            'attendances' => 'required|array',
            'attendances.*.student_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:present,absent,late,excused,sick',
            'attendances.*.notes' => 'nullable|string',
        ]);

        $teacherId = auth()->id();
        
        foreach ($request->attendances as $attendanceData) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $attendanceData['student_id'],
                    'class_id' => $request->class_id,
                    'subject_id' => $request->subject_id,
                    'date' => $request->date,
                    'session' => $request->session,
                ],
                [
                    'teacher_id' => $teacherId,
                    'status' => $attendanceData['status'],
                    'notes' => $attendanceData['notes'] ?? null,
                    'time' => now()->format('H:i'),
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Show attendance recording form for a specific class.
     */
    public function create(Request $request)
    {
        $classId = $request->get('class_id');
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        
        $class = Classes::with(['students.student', 'subjects.subject'])
            ->findOrFail($classId);
        
        // Get existing attendance for this date
        $existingAttendances = Attendance::where('class_id', $classId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');
        
        // Get students directly from class enrollments
        $enrolledStudentIds = $class->students()->where('is_active', true)->pluck('student_id');
        $students = User::whereIn('id', $enrolledStudentIds)
            ->get()
            ->map(function ($student) use ($existingAttendances) {
                $existing = $existingAttendances->get($student->id);
                
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'nisn' => $student->nisn,
                    'status' => $existing ? $existing->status : 'absent',
                    'notes' => $existing ? $existing->notes : '',
                ];
            });

        return Inertia::render('attendance/create', [
            'class' => $class,
            'students' => $students,
            'date' => $date,
            'subjects' => $class->subjects,
        ]);
    }


}