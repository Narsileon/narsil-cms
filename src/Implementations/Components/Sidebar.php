<?php

namespace Narsil\Implementations\Components;

#region USE

use Narsil\Contracts\Components\Sidebar as Contract;
use Narsil\Implementations\AbstractComponent;
use Narsil\Implementations\Components\Elements\NavigationGroup;
use Narsil\Implementations\Components\Elements\NavigationItem;
use Narsil\Models\Elements\Template;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
            $collections[] = (new NavigationItem(route('entities.index', [
                'type' => $template->{Template::HANDLE},
            ]), $template->{Template::NAME}))
                ->icon('layout');
        }

        return [
            (new NavigationItem(route('dashboard'), trans('narsil::ui.dashboard')))
                ->icon('chart-pie'),
            (new NavigationGroup(trans('narsil::ui.collections')))
                ->children($collections),
            (new NavigationGroup(trans('narsil::ui.structures')))
                ->children([
                    (new NavigationItem(route('templates.index'), trans('narsil::ui.templates')))
                        ->icon('layout'),
                    (new NavigationItem(route('blocks.index'), trans('narsil::ui.blocks')))
                        ->icon('box'),
                    (new NavigationItem(route('fields.index'), trans('narsil::ui.fields')))
                        ->icon('input'),
                ]),
            (new NavigationGroup(trans('narsil::ui.users')))
                ->children([
                    (new NavigationItem(route('users.index'), trans('narsil::ui.users')))
                        ->icon('users'),
                    (new NavigationItem(route('roles.index'), trans('narsil::ui.roles')))
                        ->icon('shield'),
                ]),
            (new NavigationGroup(trans('narsil::ui.tools')))
                ->children([
                    (new NavigationItem(route('graphiql'), 'GraphQL'))
                        ->icon('database'),
                ]),
            (new NavigationGroup(trans('narsil::ui.settings')))
                ->children([
                    (new NavigationItem(route('sites.index'), trans('narsil::ui.sites')))
                        ->icon('globe'),
                ]),

        ];
    }

    #endregion
}
