<?php

namespace App\Http\Components\Navigation;

#region USE

use App\Contracts\Components\Navigation\UserMenu as Contract;
use App\Enums\Forms\MethodEnum;
use App\Http\Components\AbstractComponent;
use App\Support\Components\NavigationItem;
use App\Support\Components\Separator;
use App\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AuthMenu extends AbstractComponent implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
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
            (new NavigationItem(route('logout'), trans('ui.log_out')))
                ->setIcon('log-out')
                ->setMethod(MethodEnum::POST)
                ->get()
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('accessibility.toggle_user_menu');
    }


    #endregion
}
