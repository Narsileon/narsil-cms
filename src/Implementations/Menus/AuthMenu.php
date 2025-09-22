<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\AuthMenu as Contract;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractMenu;
use Narsil\Support\LabelsBag;
use Narsil\Support\MenuItem;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class AuthMenu extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::bookmarks.tooltip')
            ->add('narsil::accessibility.toggle_user_menu');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new MenuItem()
                ->group(1)
                ->href(route('user-configuration.index'))
                ->icon('settings')
                ->label(trans('narsil::ui.settings'))
                ->modal(true),
            new MenuItem()
                ->group(2)
                ->href(route('logout'))
                ->icon('log-out')
                ->label(trans('narsil::ui.log_out'))
                ->method(MethodEnum::POST),
        ];
    }

    #endregion
}
