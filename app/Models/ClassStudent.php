<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ClassStudent
 *
 * @property int $id
 * @property int $class_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon $enrollment_date
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\Classes $class
 * @property-read \App\Models\User $student
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereEnrollmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClassStudent active()
 * @method static \Database\Factories\ClassStudentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ClassStudent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'class_id',
        'student_id',
        'enrollment_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'enrollment_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active enrollments.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the class that owns this enrollment.
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class);
    }

    /**
     * Get the student that owns this enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}