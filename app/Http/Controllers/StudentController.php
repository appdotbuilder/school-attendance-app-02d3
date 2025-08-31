<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = User::students()
            ->with(['classStudents.class'])
            ->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->whereHas('classStudents', function($q) use ($request) {
                $q->where('class_id', $request->class_id)->where('is_active', true);
            });
        }

        $students = $query->paginate(15);
        $classes = Classes::where('is_active', true)->get();

        return Inertia::render('students/index', [
            'students' => $students,
            'classes' => $classes,
            'filters' => $request->only(['search', 'class_id']),
        ]);
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $classes = Classes::where('is_active', true)->get();

        return Inertia::render('students/create', [
            'classes' => $classes,
        ]);
    }

    /**
     * Store a newly created student.
     */
    public function store(StoreStudentRequest $request)
    {
        $studentData = $request->validated();
        $studentData['password'] = Hash::make($studentData['nisn'] ?? 'password123');
        $studentData['role'] = 'student';

        $student = User::create($studentData);

        // Enroll in class if provided
        if ($request->filled('class_id')) {
            ClassStudent::create([
                'student_id' => $student->id,
                'class_id' => $request->class_id,
                'enrollment_date' => now(),
            ]);
        }

        return redirect()->route('students.show', $student)
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
        $student->load([
            'classStudents.class',
            'attendances' => function($query) {
                $query->with(['class', 'subject'])
                      ->latest()
                      ->limit(20);
            },
            'leaveRequests' => function($query) {
                $query->latest()->limit(10);
            },
            'parents'
        ]);

        // Calculate attendance statistics
        $totalAttendances = $student->attendances()->count();
        $presentCount = $student->attendances()->where('status', 'present')->count();
        $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 1) : 0;

        return Inertia::render('students/show', [
            'student' => $student,
            'attendance_stats' => [
                'total' => $totalAttendances,
                'present' => $presentCount,
                'absent' => $student->attendances()->where('status', 'absent')->count(),
                'rate' => $attendanceRate,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        $student->load('classStudents.class');
        $classes = Classes::where('is_active', true)->get();

        return Inertia::render('students/edit', [
            'student' => $student,
            'classes' => $classes,
        ]);
    }

    /**
     * Update the specified student.
     */
    public function update(UpdateStudentRequest $request, User $student)
    {
        $studentData = $request->validated();

        // Update password if provided
        if ($request->filled('password')) {
            $studentData['password'] = Hash::make($request->password);
        } else {
            unset($studentData['password']);
        }

        $student->update($studentData);

        // Update class enrollment if changed
        if ($request->filled('class_id')) {
            ClassStudent::where('student_id', $student->id)->update(['is_active' => false]);
            
            ClassStudent::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'class_id' => $request->class_id,
                ],
                [
                    'is_active' => true,
                    'enrollment_date' => now(),
                ]
            );
        }

        return redirect()->route('students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(User $student)
    {
        $student->update(['is_active' => false]);

        return redirect()->route('students.index')
            ->with('success', 'Student deactivated successfully.');
    }
}