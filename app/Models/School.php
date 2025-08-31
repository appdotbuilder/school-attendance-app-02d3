<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\School
 *
 * @property int $id
 * @property string $name
 * @property string|null $npsn
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $principal_name
 * @property string|null $level
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereNpsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School wherePrincipalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School active()
 * @method static \Database\Factories\SchoolFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'npsn',
        'address',
        'phone',
        'email',
        'principal_name',
        'level',
        'start_time',
        'end_time',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Scope a query to only include active schools.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}