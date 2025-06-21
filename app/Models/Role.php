<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'faculty_id'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    // public function permissions(): BelongsToMany
    // {
    //     return $this->belongsToMany(Permission::class, 'role_permission');
    // }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    protected static function booted(): void
    {
        static::deleting(function ($role): void {
            $role->users()->detach();
            $role->permissions()->detach();
        });
    }
}
