<?php

namespace Narsil\Observers;

#region USE

use Illuminate\Support\Facades\Config;
use Narsil\Models\Sites\SitePageEntity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageEntityObserver
{
    #region PUBLIC METHODS

    /**
     * @param SitePageEntity $model
     *
     * @return void
     */
    public function saving(SitePageEntity $model): void
    {
        if (!$model->{SitePageEntity::LANGUAGE})
        {
            $model->{SitePageEntity::LANGUAGE} = Config::get('app.locale');
        }
    }

    #endregion
}
