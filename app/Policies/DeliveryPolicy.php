<?php

namespace App\Policies;

use App\Models\Delivery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DeliveryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny($user)
    {
        //
        return $user->hasPermissionTo('Read-Deliveries')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Delivery $delivery)
    {
        //
        return $user->hasPermissionTo('Read-Deliveries')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create($user)
    {
        //
        return $user->hasPermissionTo('Create-Delivery')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update($user, Delivery $delivery)
    {
        //
        return $user->hasPermissionTo('Update-Delivery')
            ? $this->allow()
            : $this->deny(__('cms.permissionreadeeroor'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete($user, Delivery $delivery)
    {
        //
        return $user->hasPermissionTo('Delete-Delivery')
            ? $this->allow()
            : $this->deny(__('cms.permissiondelete'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Delivery $delivery)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Delivery $delivery)
    {
        //
    }
}
