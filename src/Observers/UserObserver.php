<?php

namespace Narsil\Cms\Observers;

#region USE

use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserObserver
{
    #region PUBLIC METHODS

    /**
     * @param User $model
     *
     * @return void
     */
    public function created(User $model): void
    {
        $this->createUserConfiguration($model);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param User $model
     *
     * @return void
     */
    protected function createUserConfiguration(User $model): void
    {
        if (!$model->configuration()->exists())
        {
            $model->configuration()->create();
        }
    }

    #endregion
}
