<?php

namespace Aammui\RolePermission\Traits;

use Aammui\RolePermission\Models\Role;

trait HasRole
{
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function addRole($role)
    {
        $role = collect($role)->map(function ($item) {
            return Role::firstOrCreate(["name" => $item]);
        })->pluck('id');

        return $this->role()->sync($role);
    }

    public function getRoles()
    {
        return $this->role->map(function ($item) {
            return $item->name;
        })->toArray();
    }

    /**
     * Check if a user has got a given role
     * @param array $roles 
     * @return bool 
     */
    public function hasGotRole(array $roles): bool
    {
        return count(array_intersect($this->getRoles(), $roles)) > 0;
    }
}
