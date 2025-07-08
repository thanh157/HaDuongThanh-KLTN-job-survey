<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role as RoleEnum;
use App\Enums\Status;
use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Role;


/**
 *
 *
 * @property int $id
 * @property int $sso_id
 * @property Status $status
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read string $role_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Role> $userRoles
 * @property-read int|null $user_roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSsoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'sso_id',
        'status',
        'full_name',
        'code',
        'access_token',
        'user_data',
        'faculty_id',
        'role_id',
        'type',
    ];

    protected $casts = [
        'status' => Status::class,
        'user_data' => 'array',
        'type' => UserType::class,
    ];

    protected $appends = ['role_name'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function hasPermission(string $permissionCode): bool
    {
        if ($this->role === RoleEnum::SuperAdmin->value) {
            return true;
        }

        return $this->userRoles()->whereHas('permissions', function ($query) use ($permissionCode): void {
            $query->where('code', $permissionCode);
        })->exists();
    }


    public function getRoleNameAttribute(): string
    {
        return $this->userRoles()->pluck('name')->implode(', ');
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::SuperAdmin->value;
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === RoleEnum::SuperAdmin->value;
    }

    public function isStudent(): bool
    {
        return $this->role === RoleEnum::Student->value;
    }

    /**
     * Scope a query to filter users by search term.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $search
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search): \Illuminate\Database\Eloquent\Builder
    {
        if ($search) {
            $query->where('full_name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    /**
     * Scope a query to only include users with a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to exclude users with a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExcludeType($query, $type): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('type', '!=', $type);
    }
}
