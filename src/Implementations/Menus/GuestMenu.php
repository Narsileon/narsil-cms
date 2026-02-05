<?php

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Cms\Contracts\Menus\GuestMenu as Contract;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Implementations\AbstractMenu;
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\MenuItem;
use Narsil\Ui\Support\TranslationsBag;

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
                ->method(RequestMethodEnum::GET->value),
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
