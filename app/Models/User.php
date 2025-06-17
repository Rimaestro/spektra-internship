<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone_number',
        'address',
        'profile_photo',
        'nim',
        'nip',
        'department',
        'semester',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the company that owns the user.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get internships where user is a student.
     */
    public function studentInternships(): HasMany
    {
        return $this->hasMany(Internship::class, 'student_id');
    }

    /**
     * Get internships where user is a supervisor.
     */
    public function supervisorInternships(): HasMany
    {
        return $this->hasMany(Internship::class, 'supervisor_id');
    }

    /**
     * Get internships where user is a field supervisor.
     */
    public function fieldSupervisorInternships(): HasMany
    {
        return $this->hasMany(Internship::class, 'field_supervisor_id');
    }

    /**
     * Get internships where user is a coordinator.
     */
    public function coordinatorInternships(): HasMany
    {
        return $this->hasMany(Internship::class, 'coordinator_id');
    }

    /**
     * Get evaluations created by the user.
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }

    /**
     * Check if user has a specific role by name.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role->name === $roleName;
    }

    /**
     * Check if user is a student.
     */
    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    /**
     * Check if user is a supervisor.
     */
    public function isSupervisor(): bool
    {
        return $this->hasRole('supervisor');
    }

    /**
     * Check if user is a field supervisor.
     */
    public function isFieldSupervisor(): bool
    {
        return $this->hasRole('field_supervisor');
    }

    /**
     * Check if user is a coordinator.
     */
    public function isCoordinator(): bool
    {
        return $this->hasRole('coordinator');
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
}
