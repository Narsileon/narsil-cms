<?php

namespace Narsil\Implementations\Components;

#region USE

use Narsil\Contracts\Components\AuthMenu as Contract;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Components\Elements\NavigationItem;
use Narsil\Implementations\Components\Elements\Separator;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AuthMenu extends AbstractComponent implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::accessibility.toggle_user_menu');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new NavigationItem(route('user-configuration.index'), trans('narsil::ui.settings'))
                ->icon('settings')
                ->modal(true),
            new Separator(),
            new NavigationItem(route('logout'), trans('narsil::ui.log_out'))
                ->icon('log-out')
                ->method(MethodEnum::POST),
        ];
    }

    #endregion
}
