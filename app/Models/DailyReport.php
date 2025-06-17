<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'internship_id',
        'report_date',
        'check_in',
        'check_out',
        'activities',
        'obstacles',
        'solutions',
        'attachment',
        'latitude',
        'longitude',
        'is_approved',
        'supervisor_comment',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_approved' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the internship that owns the daily report.
     */
    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class);
    }

    /**
     * Get the student that created the daily report.
     */
    public function student()
    {
        return $this->internship->student;
    }

    /**
     * Get the duration of work in hours.
     */
    public function getDurationAttribute()
    {
        if ($this->check_in && $this->check_out) {
            return $this->check_in->diffInHours($this->check_out);
        }
        
        return 0;
    }

    /**
     * Get the formatted duration as string.
     */
    public function getFormattedDurationAttribute()
    {
        $duration = $this->duration;
        
        if ($duration < 1) {
            return $this->check_in->diffInMinutes($this->check_out) . ' menit';
        }
        
        return $duration . ' jam';
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateBetween($query, $start, $end)
    {
        return $query->whereBetween('report_date', [$start, $end]);
    }
}
