<?php

namespace App\Http\Components;

#region USE

use App\Interfaces\Components\ISidebarComponent;
use App\Support\LabelsBag;
use App\Support\NavigationItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SidebarComponent extends AbstractComponent implements ISidebarComponent
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new NavigationItem(route('users.index'), trans('ui.users')))
                ->icon('users')
                ->get(),
            (new NavigationItem(route('settings'), trans('ui.settings')))
                ->icon('settings')
                ->get(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function registerLabels(): void
    {
        app(LabelsBag::class)
            ->add('accessibility.close_sidebar')
            ->add('accessibility.open_sidebar')
            ->add('accessibility.toggle_sidebar');
    }


    #endregion
}
