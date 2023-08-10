<?php

namespace App\Policies;

use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PharmacistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user)
    {
        //
        return $user->hasPermissionTo('Read-Pharmacists')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Pharmacist $pharmacist)
    {
        //
        return $user->hasPermissionTo('Read-Pharmacists')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user)
    {
        //
        return $user->hasPermissionTo('Create-Pharmacist')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Pharmacist $pharmacist)
    {
        //
        return $user->hasPermissionTo('Update-Pharmacist')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Pharmacist $pharmacist)
    {
        //
        return $user->hasPermissionTo('Delete-Pharmacist')
            ? $this->allow()
            : $this->deny(__('cms.permissiondelete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pharmacist $pharmacist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pharmacist $pharmacist)
    {
        //
    }
}
