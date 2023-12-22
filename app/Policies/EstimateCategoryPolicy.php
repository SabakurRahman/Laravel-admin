<?php

namespace App\Policies;

use App\Models\EstimateCategory;
use App\Models\ProjectEstimateCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EstimateCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EstimateCategory $EstimateCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EstimateCategory $projectEstimateCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EstimateCategory $projectEstimateCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EstimateCategory $projectEstimateCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EstimateCategory $projectEstimateCategory): bool
    {
        //
    }
}
