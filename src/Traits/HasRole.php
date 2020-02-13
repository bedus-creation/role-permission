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
            return Role::firstOrCreate(["name" => strtolower($item)]);
        })->pluck('id');

        return $this->role()->sync($role);
    }

    public function getRoles()
    {
        return collect($this->role)->map(function ($item) {
            return strtolower($item->name);
        })->toArray();
    }

    /**
     * Check if a user has got a given role
     * @param mixed $roles 
     * @return bool 
     */
    public function hasGotRole($roles): bool
    {
        $roles = collect($roles)
            ->map(function ($item) {
                return strtolower($item);
            })->toArray();
        // dump($this->getRoles());
        // dump(count(array_intersect($roles, $this->getRoles())) > 0);
        return count(array_intersect($this->getRoles(), $roles)) > 0;
    }
}
