<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Classes
 *
 * @property int $id
 * @property string $name
 * @property string $grade
 * @property string|null $major
 * @property int $academic_year_id
 * @property int|null $homeroom_teacher_id
 * @property int $capacity
 * @property string|null $description
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\AcademicYear $academicYear
 * @property-read \App\Models\User|null $homeroomTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClassStudent> $students
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClassSubject> $subjects
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attendance> $attendances
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Classes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes query()
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereAcademicYearId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereHomeroomTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Classes active()
 * @method static \Database\Factories\ClassesFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Classes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'grade',
        'major',
        'academic_year_id',
        'homeroom_teacher_id',
        'capacity',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active classes.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the academic year that owns this class.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the homeroom teacher for this class.
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    /**
     * Get the students in this class.
     */
    public function students(): HasMany
    {
        return $this->hasMany(ClassStudent::class, 'class_id');
    }

    /**
     * Get the subjects for this class.
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'class_id');
    }

    /**
     * Get the attendance records for this class.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }
}