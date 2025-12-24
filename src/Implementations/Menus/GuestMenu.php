<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\GuestMenu as Contract;
use Narsil\Enums\Forms\MethodEnum;
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
class GuestMenu extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
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
        $group = 'login-group';

        return [
            new MenuItem()
                ->group($group)
                ->href(route('login'))
                ->icon('log-in')
                ->label(trans('narsil::ui.log_in'))
                ->method(MethodEnum::GET->value),
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
                ->method(MethodEnum::GET->value)
                ->modal(true),
        ];
    }


    #endregion
}
