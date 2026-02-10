<?php

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Menus\GuestMenu as Contract;
use Narsil\Cms\Implementations\AbstractMenu;
use Narsil\Cms\Models\Users\UserConfiguration;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\MenuItem;

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
            ->add('narsil-cms::accessibility.toggle_user_menu')
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
        $this
            ->add(
                new MenuItem('settings')
                    ->icon('settings')
                    ->label(ModelService::getTableLabel(UserConfiguration::TABLE))
                    ->route('user-configurations.edit')
                    ->modal(true),
            )
            ->add(
                new MenuItem('login')
                    ->icon('log-in')
                    ->label(trans('narsil-cms::ui.log_in'))
                    ->route('login'),
            );

        return parent::content();
    }

    #endregion
}
