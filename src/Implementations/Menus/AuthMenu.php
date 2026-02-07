<?php

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Cms\Contracts\Menus\AuthMenu as Contract;
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
class AuthMenu extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::accessibility.toggle_user_menu')
            ->add('narsil-cms::bookmarks.tooltip')
            ->add('narsil-cms::themes.dark')
            ->add('narsil-cms::themes.light')
            ->add('narsil-cms::themes.system');
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
                ->label(trans('narsil-cms::ui.log_out'))
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
