<?php

namespace Narsil\Implementations\Components;

#region USE

use Narsil\Contracts\Components\Sidebar as Contract;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Components\Elements\NavigationItem;
use Narsil\Support\LabelsBag;

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
            (new NavigationItem(route('field-sets.index'), trans('narsil-cms::ui.fields')))
                ->icon('globe')
                ->toArray(),
            (new NavigationItem(route('sites.index'), trans('narsil-cms::ui.sites')))
                ->icon('globe')
                ->toArray(),
            (new NavigationItem(route('users.index'), trans('narsil-cms::ui.users')))
                ->icon('users')
                ->toArray(),

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
