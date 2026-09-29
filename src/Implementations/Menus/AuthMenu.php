<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Contracts\Menus\AuthMenu as Contract;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Implementations\Menu;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Support\MenuItem;

#endregion

class AuthMenu extends Menu implements Contract
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
                new MenuItem('logout')
                    ->icon('fa-regular-right-from-bracket')
                    ->label(trans('narsil::ui.log_out'))
                    ->route('logout')
                    ->method(RequestMethodEnum::POST->value),
            );

        return parent::content();
    }

    #endregion
}
