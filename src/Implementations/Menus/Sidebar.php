<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\Sidebar as Contract;
use Narsil\Implementations\AbstractMenu;
use Narsil\Models\Elements\Template;
use Narsil\Support\TranslationsBag;
use Narsil\Support\MenuItem;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Sidebar extends AbstractMenu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
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
        return array_merge(
            [
                new MenuItem()
                    ->href(route('dashboard'))
                    ->icon('chart-pie')
                    ->label(trans('narsil::ui.dashboard')),
            ],
            $this->getCollectionGroup(),
            $this->getStructuresGroup(),
            $this->getManagementGroup(),
            $this->getToolsGroup(),
        );
    }

    /**
     * @return array<MenuItem>
     */
    protected function getCollectionGroup(): array
    {
        $menuItems = [];

        $group = trans('narsil::ui.collections');

        $templates = Template::query()
            ->orderBy(Template::NAME)
            ->get();

        foreach ($templates as $template)
        {
            $menuItems[] = new MenuItem()
                ->group($group)
                ->href(route('collections.index', [
                    'collection' => $template->{Template::HANDLE},
                ]))
                ->icon('layout')
                ->label($template->{Template::NAME});
        }

        return $menuItems;
    }

    /**
     * @return array<MenuItem>
     */
    protected function getManagementGroup(): array
    {
        $group = trans('narsil::ui.management');

        return [
            new MenuItem()
                ->group($group)
                ->href(route('sites.index'))
                ->icon('globe')
                ->label(trans('narsil::tables.sites')),
            new MenuItem()
                ->group($group)
                ->href(route('users.index'))
                ->icon('users')
                ->label(trans('narsil::tables.users')),
            new MenuItem()
                ->group($group)
                ->href(route('roles.index'))
                ->icon('shield')
                ->label(trans('narsil::tables.roles')),
        ];
    }

    /**
     * @return array<MenuItem>
     */
    protected function getStructuresGroup(): array
    {
        $group = trans('narsil::ui.structures');

        return [
            new MenuItem()
                ->group($group)
                ->href(route('templates.index'))
                ->icon('layout')
                ->label(trans('narsil::tables.templates')),
            new MenuItem()
                ->group($group)
                ->href(route('blocks.index'))
                ->icon('box')
                ->label(trans('narsil::tables.blocks')),
            new MenuItem()
                ->group($group)
                ->href(route('fields.index'))
                ->icon('input')
                ->label(trans('narsil::tables.fields')),
        ];
    }

    /**
     * @return array<MenuItem>
     */
    protected function getToolsGroup(): array
    {
        $group = trans('narsil::ui.tools');

        return [
            new MenuItem()
                ->group($group)
                ->href(route('graphiql'))
                ->icon('database')
                ->label(trans('narsil::ui.graphiql')),
        ];
    }

    #endregion
}
