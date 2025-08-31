<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\StudentParent
 *
 * @property int $id
 * @property int $student_id
 * @property int $parent_id
 * @property string $relation
 * @property bool $is_primary
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User $parent
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent query()
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StudentParent primary()
 * @method static \Database\Factories\StudentParentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class StudentParent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'parent_id',
        'relation',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Scope a query to only include primary relationships.
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Get the student that owns this relationship.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the parent that owns this relationship.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}