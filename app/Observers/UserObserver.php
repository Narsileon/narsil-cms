<?php

namespace App\Observers;

#region USE

use App\Models\User;

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
        if (!$user->configuration()->exists())
        {
            $user->configuration()->create();
        }
    }

    #endregion
}
