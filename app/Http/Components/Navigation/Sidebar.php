<?php

namespace App\Http\Components\Navigation;

#region USE

use App\Contracts\Components\Navigation\Sidebar as Contract;
use App\Http\Components\AbstractComponent;
use App\Support\LabelsBag;
use App\Support\Components\NavigationItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Sidebar extends AbstractComponent implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        return [
            (new NavigationItem(route('sites.index'), trans('ui.sites')))
                ->setIcon('globe')
                ->get(),
            (new NavigationItem(route('users.index'), trans('ui.users')))
                ->setIcon('users')
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
