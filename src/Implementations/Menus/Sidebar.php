<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\Sidebar as Contract;
use Narsil\Implementations\AbstractMenu;
use Narsil\Models\Elements\Template;
use Narsil\Models\Hosts\Host;
use Narsil\Support\TranslationsBag;
use Narsil\Support\MenuItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
            $this->getSiteGroup(),
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
                ->icon('layers')
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
                ->href(route('hosts.index'))
                ->icon('server')
                ->label(trans('narsil::tables.hosts')),
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
    protected function getSiteGroup(): array
    {
        $menuItems = [];

        $group = trans('narsil::ui.sites');

        $hosts = Host::query()
            ->orderBy(Host::NAME)
            ->get();

        foreach ($hosts as $host)
        {
            $menuItems[] = new MenuItem()
                ->group($group)
                ->href(route('sites.edit', [
                    'country' => 'default',
                    'site' => $host->{Host::HANDLE}
                ]))
                ->icon('globe')
                ->label($host->{Host::NAME});
        }

        return $menuItems;
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
                ->icon('braces')
                ->label(trans('narsil::ui.graphiql'))
                ->target('_blank'),
        ];
    }

    #endregion
}
