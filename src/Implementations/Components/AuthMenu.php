<?php

namespace Narsil\Implementations\Components;

#region USE

use Narsil\Contracts\Components\AuthMenu as Contract;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Components\Elements\NavigationItem;
use Narsil\Implementations\Components\Elements\Separator;
use Narsil\Support\LabelsBag;

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
    protected function content(): array
    {
        return [
            (new NavigationItem(route('user-configuration.index'), trans('narsil-cms::ui.settings')))
                ->icon('settings')
                ->modal(true)
                ->toArray(),
            (new Separator)
                ->toArray(),
            (new NavigationItem(route('logout'), trans('narsil-cms::ui.log_out')))
                ->icon('log-out')
                ->method(MethodEnum::POST)
                ->toArray()
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
