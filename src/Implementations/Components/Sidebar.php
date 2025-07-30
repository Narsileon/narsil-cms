<?php

namespace Narsil\Implementations\Components;

#region USE

use Narsil\Contracts\Components\Sidebar as Contract;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Components\Elements\NavigationGroup;
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
            (new NavigationItem(route('dashboard'), trans('narsil-cms::ui.dashboard')))
                ->icon('chart-pie')
                ->toArray(),
            (new NavigationGroup(trans('narsil-cms::ui.structures')))
                ->children([
                    (new NavigationItem(route('templates.index'), trans('narsil-cms::ui.templates')))
                        ->icon('layout-template')
                        ->toArray(),
                    (new NavigationItem(route('blocks.index'), trans('narsil-cms::ui.blocks')))
                        ->icon('box')
                        ->toArray(),
                    (new NavigationItem(route('fields.index'), trans('narsil-cms::ui.fields')))
                        ->icon('rectangle-ellipsis')
                        ->toArray(),
                ])
                ->toArray(),

            (new NavigationGroup(trans('narsil-cms::ui.users')))
                ->children([
                    (new NavigationItem(route('users.index'), trans('narsil-cms::ui.users')))
                        ->icon('users')
                        ->toArray(),
                    (new NavigationItem(route('roles.index'), trans('narsil-cms::ui.roles')))
                        ->icon('shield')
                        ->toArray(),
                ])
                ->toArray(),
            (new NavigationGroup(trans('narsil-cms::ui.settings')))
                ->children([
                    (new NavigationItem(route('sites.index'), trans('narsil-cms::ui.sites')))
                        ->icon('globe')
                        ->toArray(),
                ])
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
