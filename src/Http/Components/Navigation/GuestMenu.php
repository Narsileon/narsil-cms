<?php

namespace Narsil\Http\Components\Navigation;

#region USE

use Narsil\Contracts\Components\Navigation\UserMenu as Contract;
use Narsil\Http\Components\AbstractComponent;
use Narsil\Support\LabelsBag;
use Narsil\Support\Components\NavigationItem;
use Narsil\Support\Components\Separator;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class GuestMenu extends AbstractComponent implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            (new NavigationItem(route('user-configuration.index'), trans('narsil-cms::ui.settings')))
                ->setIcon('settings')
                ->setModal(true)
                ->get(),
            (new Separator)
                ->get(),
            (new NavigationItem(route('login'), trans('narsil-cms::ui.log_in')))
                ->setIcon('log-in')
                ->get(),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('narsil-cms::accessibility.toggle_user_menu');
    }


    #endregion
}
