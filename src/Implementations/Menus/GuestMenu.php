<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Contracts\Menus\GuestMenu as Contract;
use Narsil\Base\Implementations\Menu;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Support\MenuItem;

#endregion

class GuestMenu extends Menu implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        $this
            ->add(
                new MenuItem('settings')
                    ->icon('fa-regular-gear')
                    ->label(ModelService::getTableLabel(UserConfiguration::TABLE))
                    ->route('user-configurations.edit')
                    ->modal(true),
            )
            ->add(
                new MenuItem('login')
                    ->icon('fa-regular-right-to-bracket')
                    ->label(trans('narsil::ui.log_in'))
                    ->route('login'),
            );

        return parent::content();
    }

    #endregion
}
