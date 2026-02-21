<?php

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Menus\AuthMenu as Contract;
use Narsil\Cms\Implementations\Menu;
use Narsil\Cms\Support\MenuItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AuthMenu extends Menu implements Contract
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
        $this
            ->add(
                new MenuItem('settings')
                    ->icon('settings')
                    ->label(ModelService::getTableLabel(UserConfiguration::TABLE))
                    ->route('user-configurations.edit')
                    ->modal(true),
            )
            ->add(
                new MenuItem('logout')
                    ->icon('log-out')
                    ->label(trans('narsil::ui.log_out'))
                    ->route('logout')
                    ->method(RequestMethodEnum::POST->value),
            );

        return parent::content();
    }

    #endregion
}
