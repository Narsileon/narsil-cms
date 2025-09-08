<?php

namespace Narsil\Implementations\Blocks;

#region USE

use Narsil\Contracts\Blocks\Sidebar as Contract;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Blocks\Elements\NavigationGroup;
use Narsil\Implementations\Blocks\Elements\NavigationItem;
use Narsil\Models\Elements\Template;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Sidebar extends AbstractComponent implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(LabelsBag::class)
            ->add('narsil::accessibility.close_sidebar')
            ->add('narsil::accessibility.open_sidebar')
            ->add('narsil::accessibility.toggle_sidebar');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        $templates = Template::query()
            ->orderBy(Template::NAME)
            ->get();

        $collections = [];

        foreach ($templates as $template)
        {
            $collections[] = new NavigationItem(route('collections.index', [
                'collection' => $template->{Template::HANDLE},
            ]), $template->{Template::NAME})
                ->icon('layout');
        }

        return [
            new NavigationItem(route('dashboard'), trans('narsil::ui.dashboard'))
                ->icon('chart-pie'),
            new NavigationGroup(trans('narsil::ui.collections'))
                ->children($collections),
            new NavigationGroup(trans('narsil::ui.structures'))
                ->children([
                    new NavigationItem(route('templates.index'), trans('narsil::tables.templates'))
                        ->icon('layout'),
                    new NavigationItem(route('blocks.index'), trans('narsil::tables.blocks'))
                        ->icon('box'),
                    new NavigationItem(route('fields.index'), trans('narsil::tables.fields'))
                        ->icon('input'),
                ]),
            new NavigationGroup(trans('narsil::ui.management'))
                ->children([
                    new NavigationItem(route('users.index'), trans('narsil::tables.users'))
                        ->icon('users'),
                    new NavigationItem(route('roles.index'), trans('narsil::tables.roles'))
                        ->icon('shield'),
                ]),
            new NavigationGroup(trans('narsil::ui.tools'))
                ->children([
                    new NavigationItem(route('graphiql'), trans('narsil::ui.graphiql'))
                        ->icon('database'),
                ]),
            new NavigationGroup(trans('narsil::ui.settings'))
                ->children([
                    new NavigationItem(route('sites.index'), trans('narsil::tables.sites'))
                        ->icon('globe'),
                ]),

        ];
    }

    #endregion
}
