<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\GuestMenu as Contract;
use Narsil\Implementations\AbstractMenu;
use Narsil\Support\LabelsBag;
use Narsil\Support\MenuItem;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class GuestMenu extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::accessibility.toggle_user_menu')
            ->add('narsil::themes.dark')
            ->add('narsil::themes.light')
            ->add('narsil::themes.system');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return array_merge(
            $this->getSettingsGroup(),
            $this->getLoginGroup(),
        );
    }

    /**
     * @return array<MenuItem>
     */
    protected function getLoginGroup(): array
    {
        $group = "login-group";

        return [
            new MenuItem()
                ->group($group)
                ->href(route('login'))
                ->icon('log-in')
                ->label(trans('narsil::ui.log_in')),
        ];
    }

    /**
     * @return array<MenuItem>
     */
    protected function getSettingsGroup(): array
    {
        $group = "settings-group";

        return [
            new MenuItem()
                ->group($group)
                ->href(route('user-configuration.index'))
                ->icon('settings')
                ->label(trans('narsil::ui.settings'))
                ->modal(true),
        ];
    }


    #endregion
}
