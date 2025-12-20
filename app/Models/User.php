<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string $status
 * @property-read string $role
 */
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
        'phone',
        'status',
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

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Many-to-Many roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('starts_at', 'ends_at')
            ->withTimestamps();
    }

    /**
     * Active roles (not expired).
     */
    public function activeRoles(): BelongsToMany
    {
        return $this->roles()
            ->wherePivot('starts_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('role_user.ends_at')
                    ->orWhere('role_user.ends_at', '>', now());
            });
    }

    /**
     * Supporter profile.
     */
    public function supporterProfile(): HasOne
    {
        return $this->hasOne(SupporterProfile::class);
    }

    /**
     * Tasks assigned to this user.
     */
    public function assignedTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    /**
     * Tasks created by this manager.
     */
    public function managedTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'manager_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Backward compatibility: Get the primary active role slug.
     */
    public function getRoleAttribute(): string
    {
        return $this->activeRoles->first()?->slug ?? 'guest';
    }

    /**
     * Check if user has a specific active role.
     */
    public function hasRole(string|array $roleSlug): bool
    {
        $activeRoleSlugs = $this->activeRoles->pluck('slug')->toArray();

        if (is_array($roleSlug)) {
            return !empty(array_intersect($roleSlug, $activeRoleSlugs));
        }

        return in_array($roleSlug, $activeRoleSlugs);
    }

    /**
     * Get all active role slugs formatted as a string.
     */
    public function getFormattedRolesAttribute(): string
    {
        return $this->activeRoles->pluck('slug')->implode(', ') ?: 'guest';
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole(string $roleSlug, ?string $endsAt = null): void
    {
        $role = Role::where('slug', $roleSlug)->firstOrFail();

        $this->roles()->syncWithoutDetaching([
            $role->id => [
                'starts_at' => now(),
                'ends_at' => $endsAt
            ]
        ]);
    }

    /**
     * Revoke a role from the user (sets ends_at to now).
     */
    public function revokeRole(string $roleSlug): void
    {
        $role = Role::where('slug', $roleSlug)->firstOrFail();

        $this->roles()->updateExistingPivot($role->id, [
            'ends_at' => now()
        ]);
    }
}
