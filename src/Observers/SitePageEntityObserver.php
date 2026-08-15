<?php

declare(strict_types=1);

namespace Narsil\Cms\Observers;

#region USE

use Illuminate\Support\Facades\Config;
use Narsil\Cms\Models\Sites\SitePageEntity;

#endregion

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
