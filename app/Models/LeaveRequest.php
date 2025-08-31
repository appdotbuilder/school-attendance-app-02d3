<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LeaveRequest
 *
 * @property int $id
 * @property int $student_id
 * @property int $submitted_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $type
 * @property string $reason
 * @property string|null $attachment
 * @property string $status
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon $submitted_at
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $student
 * @property-read \App\Models\User $submitter
 * @property-read \App\Models\User|null $approver
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereAdminNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereSubmittedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest pending()
 * @method static \Illuminate\Database\Eloquent\Builder|LeaveRequest approved()
 * @method static \Database\Factories\LeaveRequestFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LeaveRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'submitted_by',
        'approved_by',
        'start_date',
        'end_date',
        'type',
        'reason',
        'attachment',
        'status',
        'admin_notes',
        'submitted_at',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Get the student that owns this leave request.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the user who submitted this leave request.
     */
    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    /**
     * Get the user who approved this leave request.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}