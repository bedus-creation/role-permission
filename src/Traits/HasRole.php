<?php

namespace Aammui\RolePermission\Traits;

use Aammui\RolePermission\Models\Role;

trait HasRole
{
    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function addRole($role): array
    {
        $role = collect($role)->map(function ($item) {
            return Role::firstOrCreate(["name" => strtolower($item)]);
        })->pluck('id');

        return $this->role()->sync($role);
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return collect($this->role()->get())->map(function ($item) {
            return strtolower($item->name);
        })->toArray();
    }

    /**
     * Check if a user has got a given role
     *
     * @param mixed $roles
     *
     * @return bool
     */
    public function hasGotRole($roles): bool
    {
        $roles = collect($roles)
            ->map(function ($item) {
                return strtolower($item);
            })->toArray();

        return count(array_intersect($this->getRoles(), $roles)) > 0;
    }
}
