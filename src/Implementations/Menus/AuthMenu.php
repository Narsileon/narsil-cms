<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Base\Contracts\Menus\AuthMenu as Contract;
use Narsil\Base\Implementations\Menu;
use Narsil\Base\Support\MenuItem;

#endregion

class AuthMenu extends Menu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::bookmarks.menu')
            ->add('narsil::themes.dark')
            ->add('narsil::themes.light')
            ->add('narsil::themes.system')
            ->add('narsil-cms::accessibility.user_menu');
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
