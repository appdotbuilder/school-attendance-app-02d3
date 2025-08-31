<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ClassSubject
 *
 * @property int $id
 * @property int $class_id
 * @property int $subject_id
 * @property int $teacher_id
 * @property int $credit_hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\Subject $subject
 * @property-read \App\Models\User $teacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Schedule> $schedules
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereCreditHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassSubject whereUpdatedAt($value)
 * @method static \Database\Factories\ClassSubjectFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ClassSubject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'class_id',
        'subject_id',
        'teacher_id',
        'credit_hours',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credit_hours' => 'integer',
    ];

    /**
     * Get the class that owns this subject assignment.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    /**
     * Get the subject that owns this assignment.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher that teaches this subject.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the schedules for this class subject.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}