<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserObserver
{
    #region PUBLIC METHODS

    /**
     * @param User $user
     *
     * @return void
     */
    public function created(User $user): void
    {
        $this->createUserConfiguration($user);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param User $user
     *
     * @return void
     */
    protected function createUserConfiguration(User $user): void
    {
        if (!$user->configuration()->exists())
        {
            $user->configuration()->create();
        }
    }

    #endregion
}
