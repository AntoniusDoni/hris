<?php

namespace App\Models;

class Role extends Model
{
    public $cascadeDeletes = ['rolePermissions'];

    protected $fillable = [
        'name',
    ];
    protected $hidden=[
        'created_at',
        'updated_at',
        "deleted_at",
        "created_by",
        "updated_by",
        "deleted_by",

    ];

    public function rolePermissions()
    {
        return $this->hasMany(RolePermission::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'role_id',
            'id',
            'id',
            'permission_id',
        );
    }
}
