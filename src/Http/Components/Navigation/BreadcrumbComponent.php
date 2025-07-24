<?php

namespace Narsil\Http\Components\Navigation;

#region USE

use Narsil\Http\Components\AbstractComponent;
use Narsil\Support\LabelsBag;
use Narsil\Support\Components\NavigationItem;

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
    protected function content(): array
    {
        return [
            (new NavigationItem(route('sites.index'), trans('narsil-cms::ui.sites')))
                ->setIcon('sites')
                ->get(),
            (new NavigationItem(route('users.index'), trans('narsil-cms::ui.users')))
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
            ->add('narsil-cms::accessibility.close_sidebar')
            ->add('narsil-cms::accessibility.open_sidebar')
            ->add('narsil-cms::accessibility.toggle_sidebar');
    }


    #endregion
}
