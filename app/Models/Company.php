<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'website',
        'description',
        'logo',
        'industry_type',
        'quota',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'quota' => 'integer',
    ];

    /**
     * Get the users for the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the internships for the company.
     */
    public function internships(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

    /**
     * The fields that belong to the company.
     */
    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class)
            ->withPivot('quota', 'requirements')
            ->withTimestamps();
    }

    /**
     * Get the field supervisors for the company.
     */
    public function fieldSupervisors(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('role', function ($query) {
            $query->where('name', 'field_supervisor');
        });
    }

    /**
     * Get available quota for the company.
     */
    public function getAvailableQuotaAttribute(): int
    {
        $usedQuota = $this->internships()
            ->whereIn('status', ['approved', 'ongoing'])
            ->count();
        
        return max(0, $this->quota - $usedQuota);
    }
}
