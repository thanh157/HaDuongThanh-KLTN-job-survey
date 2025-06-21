<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupPermission whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GroupPermission extends Model
{
    use HasFactory;

    protected $table = 'group_permissions';
    protected $fillable = ['name', 'code'];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'group', 'code');
    }
}
