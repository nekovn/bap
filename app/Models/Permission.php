<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['key', 'value'];
    protected $visible = ['key', 'value'];
    protected $table = 'permissions';

    public function scopeGetPermission($query)
    {
        return $query->select(['key', 'value'])->get()->toArray();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions_role', 'permissions_id', 'role_id')
                ->select(['roles.name']);
    }


}
