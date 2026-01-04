<?php

namespace Narsil\Observers;

#region USE

use Illuminate\Support\Facades\Config;
use Narsil\Models\Entities\EntityNodeEntity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeEntityObserver
{
    #region PUBLIC METHODS

    /**
     * @param EntityNodeEntity $model
     *
     * @return void
     */
    public function saving(EntityNodeEntity $model): void
    {
        if (!$model->{EntityNodeEntity::LANGUAGE})
        {
            $model->{EntityNodeEntity::LANGUAGE} = Config::get('app.locale');
        }
    }

    #endregion
}
