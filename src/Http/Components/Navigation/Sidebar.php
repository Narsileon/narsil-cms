<?php

namespace Narsil\Http\Components\Navigation;

#region USE

use Narsil\Contracts\Components\Navigation\Sidebar as Contract;
use Narsil\Http\Components\AbstractComponent;
use Narsil\Support\LabelsBag;
use Narsil\Support\Components\NavigationItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Sidebar extends AbstractComponent implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            (new NavigationItem(route('fields.index'), trans('narsil-cms::ui.fields')))
                ->setIcon('globe')
                ->get(),
            (new NavigationItem(route('sites.index'), trans('narsil-cms::ui.sites')))
                ->setIcon('globe')
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
