<?php

namespace App\Http\Components\Navigation;

#region USE

use App\Contracts\Components\Navigation\UserMenu as Contract;
use App\Http\Components\AbstractComponent;
use App\Support\LabelsBag;
use App\Support\Components\NavigationItem;
use App\Support\Components\Separator;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GuestMenu extends AbstractComponent implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new NavigationItem(route('user-configuration.index'), trans('ui.settings')))
                ->setIcon('settings')
                ->setModal(true)
                ->get(),
            (new Separator)
                ->get(),
            (new NavigationItem(route('login'), trans('ui.log_in')))
                ->setIcon('log-in')
                ->get(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('accessibility.toggle_user_menu');
    }


    #endregion
}
