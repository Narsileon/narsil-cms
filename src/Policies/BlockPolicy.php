<?php

namespace Narsil\Policies;

#region USE

use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Collections\Block;
use Narsil\Models\User;
use Narsil\Services\PermissionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockPolicy
{
    #region PUBLIC METHODS

    /**
     * Determine whether the user can create blocks.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function create(User $user): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::CREATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete the block.
     *
     * @param User $user
     * @param Block $model
     *
     * @return boolean
     */
    public function delete(User $user, Block $model): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can delete blocks.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function deleteAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::DELETE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can update the block.
     *
     * @param User $user
     * @param Block $model
     *
     * @return boolean
     */
    public function update(User $user, Block $model): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::UPDATE->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view the block.
     *
     * @param User $user
     * @param Block $model
     *
     * @return boolean
     */
    public function view(User $user, Block $model): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    /**
     * Determine whether the user can view blocks.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function viewAny(User $user): bool
    {
        $permission = PermissionService::getHandle(Block::TABLE, PermissionEnum::VIEW->value);

        return $user->hasPermission($permission);
    }

    #endregion
}
