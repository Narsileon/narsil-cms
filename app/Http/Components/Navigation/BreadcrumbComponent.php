<?php

namespace App\Http\Components\Navigation;

#region USE

use App\Http\Components\AbstractComponent;
use App\Support\LabelsBag;
use App\Support\Components\NavigationItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BreadcrumbComponent extends AbstractComponent
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getContent(): array
    {
        return [
            (new NavigationItem(route('sites.index'), trans('ui.sites')))
                ->setIcon('sites')
                ->get(),
            (new NavigationItem(route('users.index'), trans('ui.users')))
                ->setIcon('users')
                ->get(),

        ];
    }

    /**
     * {@inheritDoc}
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
