<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\ClassSubject;
use App\Models\ClassStudent;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create school
        $school = School::create([
            'name' => 'SMA Negeri 1 Jakarta',
            'npsn' => '20104001',
            'address' => 'Jl. Budi Kemuliaan No. 1, Jakarta Pusat',
            'phone' => '021-3456789',
            'email' => 'info@sman1jakarta.sch.id',
            'principal_name' => 'Dr. Siti Rahmawati, M.Pd',
            'level' => 'sma',
            'start_time' => '07:00:00',
            'end_time' => '15:00:00',
        ]);

        // Create academic year
        $academicYear = AcademicYear::create([
            'name' => '2024/2025',
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'is_active' => true,
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create principal
        $principal = User::create([
            'name' => 'Dr. Siti Rahmawati',
            'email' => 'principal@school.com',
            'password' => Hash::make('password'),
            'role' => 'principal',
            'nip' => '196502151990032001',
            'is_active' => true,
        ]);

        // Create teachers
        $teachers = [];
        $teacherNames = [
            'Ahmad Wijaya, S.Pd',
            'Sari Indrawati, S.Pd',
            'Budi Santoso, S.Pd',
            'Nina Kusuma, S.Pd',
            'Eko Prasetyo, S.Pd',
        ];

        foreach ($teacherNames as $index => $name) {
            $teachers[] = User::create([
                'name' => $name,
                'email' => 'teacher' . ($index + 1) . '@school.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'nip' => '19800101200012' . str_pad((string)($index + 1), 3, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
        }

        // Create subjects
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK', 'credit_hours' => 4],
            ['name' => 'Bahasa Indonesia', 'code' => 'BID', 'credit_hours' => 4],
            ['name' => 'Bahasa Inggris', 'code' => 'BIG', 'credit_hours' => 3],
            ['name' => 'Fisika', 'code' => 'FIS', 'credit_hours' => 3],
            ['name' => 'Kimia', 'code' => 'KIM', 'credit_hours' => 3],
        ];

        foreach ($subjects as $subjectData) {
            Subject::create($subjectData);
        }

        // Create classes
        $classes = [];
        $classNames = ['X IPA 1', 'X IPA 2', 'XI IPA 1', 'XI IPA 2', 'XII IPA 1'];
        $grades = ['X', 'X', 'XI', 'XI', 'XII'];

        foreach ($classNames as $index => $className) {
            $classes[] = Classes::create([
                'name' => $className,
                'grade' => $grades[$index],
                'major' => 'IPA',
                'academic_year_id' => $academicYear->id,
                'homeroom_teacher_id' => $teachers[$index % count($teachers)]->id,
                'capacity' => 30,
            ]);
        }

        // Create students
        $students = [];
        for ($i = 1; $i <= 50; $i++) {
            $students[] = User::create([
                'name' => 'Siswa ' . $i,
                'email' => 'student' . $i . '@school.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'nisn' => '00240' . str_pad((string)$i, 5, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? 'female' : 'male',
                'birth_date' => now()->subYears(random_int(16, 18))->subDays(random_int(1, 365)),
                'is_active' => true,
            ]);
        }

        // Assign students to classes
        foreach ($students as $index => $student) {
            ClassStudent::create([
                'class_id' => $classes[$index % count($classes)]->id,
                'student_id' => $student->id,
                'enrollment_date' => now()->subDays(random_int(1, 30)),
            ]);
        }

        // Assign subjects to classes
        $allSubjects = Subject::all();
        foreach ($classes as $class) {
            foreach ($allSubjects as $subjectIndex => $subject) {
                ClassSubject::create([
                    'class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teachers[$subjectIndex % count($teachers)]->id,
                    'credit_hours' => $subject->credit_hours,
                ]);
            }
        }

        // Create sample attendance records for the past week
        foreach ($classes as $class) {
            $classStudents = ClassStudent::where('class_id', $class->id)->get();
            
            for ($day = 7; $day >= 1; $day--) {
                $date = now()->subDays($day);
                
                foreach ($classStudents as $enrollment) {
                    // 85% chance of being present
                    $statuses = ['present', 'present', 'present', 'present', 'absent', 'late'];
                    $status = $statuses[array_rand($statuses)];
                    
                    Attendance::create([
                        'student_id' => $enrollment->student_id,
                        'class_id' => $class->id,
                        'teacher_id' => $class->homeroom_teacher_id,
                        'date' => $date->format('Y-m-d'),
                        'time' => $date->setTime(random_int(7, 14), random_int(0, 59))->format('H:i'),
                        'status' => $status,
                        'session' => 'full_day',
                    ]);
                }
            }
        }

        // Create parents for some students
        foreach ($students as $index => $student) {
            if ($index < 20) { // Only create parents for first 20 students
                $parent = User::create([
                    'name' => 'Orang Tua ' . $student->name,
                    'email' => 'parent' . ($index + 1) . '@school.com',
                    'password' => Hash::make('password'),
                    'role' => 'parent',
                    'phone' => '081234567' . str_pad((string)$index, 3, '0', STR_PAD_LEFT),
                    'is_active' => true,
                ]);

                \App\Models\StudentParent::create([
                    'student_id' => $student->id,
                    'parent_id' => $parent->id,
                    'relation' => 'father',
                    'is_primary' => true,
                ]);
            }
        }
    }
}