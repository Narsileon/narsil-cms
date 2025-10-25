<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\AuthMenu as Contract;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractMenu;
use Narsil\Support\TranslationsBag;
use Narsil\Support\MenuItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AuthMenu extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::accessibility.toggle_user_menu')
            ->add('narsil::bookmarks.tooltip')
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
            $this->getLogoutGroup(),
        );
    }

    /**
     * @return array<MenuItem>
     */
    protected function getLogoutGroup(): array
    {
        $group = "logout-group";

        return [
            new MenuItem()
                ->setGroup($group)
                ->setHref(route('logout'))
                ->setIcon('log-out')
                ->setLabel(trans('narsil::ui.log_out'))
                ->setMethod(MethodEnum::POST),
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
                ->setGroup($group)
                ->setHref(route('user-configuration.index'))
                ->setIcon('settings')
                ->setLabel(trans('narsil::ui.settings'))
                ->setModal(true),
        ];
    }

    #endregion
}
