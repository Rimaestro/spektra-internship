<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Internship extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'company_id',
        'supervisor_id',
        'field_supervisor_id',
        'coordinator_id',
        'start_date',
        'end_date',
        'position',
        'department',
        'status',
        'job_description',
        'rejection_reason',
        'notes',
        'internship_letter',
        'acceptance_letter',
        'completion_letter',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the student that owns the internship.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the company that owns the internship.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the supervisor that owns the internship.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the field supervisor that owns the internship.
     */
    public function fieldSupervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'field_supervisor_id');
    }

    /**
     * Get the coordinator that owns the internship.
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }

    /**
     * Get the daily reports for the internship.
     */
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }

    /**
     * Get the evaluations for the internship.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    /**
     * Scope a query to only include internships with specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Calculate the progress percentage of the internship.
     */
    public function getProgressPercentageAttribute(): int
    {
        $totalDays = $this->start_date->diffInDays($this->end_date) + 1;
        $elapsedDays = now()->diffInDays($this->start_date) + 1;
        
        if ($elapsedDays > $totalDays) {
            return 100;
        }
        
        return (int) (($elapsedDays / $totalDays) * 100);
    }

    /**
     * Check if the internship is active.
     */
    public function getIsActiveAttribute(): bool
    {
        return in_array($this->status, ['approved', 'ongoing']);
    }

    /**
     * Check if the internship is completed.
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed';
    }
}
