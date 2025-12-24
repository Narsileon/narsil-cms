<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\AuthMenu as Contract;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractMenu;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Services\ModelService;
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
        $group = 'logout-group';

        return [
            new MenuItem()
                ->group($group)
                ->href(route('logout'))
                ->icon('log-out')
                ->label(trans('narsil::ui.log_out'))
                ->method(RequestMethodEnum::POST->value),
        ];
    }

    /**
     * @return array<MenuItem>
     */
    protected function getSettingsGroup(): array
    {
        $group = 'settings-group';

        return [
            new MenuItem()
                ->group($group)
                ->href(route('user-configurations.edit'))
                ->icon('settings')
                ->label(ModelService::getTableLabel(UserConfiguration::TABLE))
                ->method(RequestMethodEnum::GET->value)
                ->modal(true),
        ];
    }

    #endregion
}
