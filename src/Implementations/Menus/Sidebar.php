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
                    ->setHref(route('dashboard'))
                    ->setIcon('chart-pie')
                    ->setLabel(trans('narsil::ui.dashboard')),
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
                ->setGroup($group)
                ->setHref(route('collections.index', [
                    'collection' => $template->{Template::HANDLE},
                ]))
                ->setIcon('layers')
                ->setLabel($template->{Template::NAME});
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
                ->setGroup($group)
                ->setHref(route('hosts.index'))
                ->setIcon('server')
                ->setLabel(trans('narsil::tables.hosts')),
            new MenuItem()
                ->setGroup($group)
                ->setHref(route('users.index'))
                ->setIcon('users')
                ->setLabel(trans('narsil::tables.users')),
            new MenuItem()
                ->setGroup($group)
                ->setHref(route('roles.index'))
                ->setIcon('shield')
                ->setLabel(trans('narsil::tables.roles')),
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
                ->setGroup($group)
                ->setHref(route('collections.summary'))
                ->setIcon('globe')
                ->setLabel($host->{Host::NAME});
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
                ->setGroup($group)
                ->setHref(route('templates.index'))
                ->setIcon('layout')
                ->setLabel(trans('narsil::tables.templates')),
            new MenuItem()
                ->setGroup($group)
                ->setHref(route('blocks.index'))
                ->setIcon('box')
                ->setLabel(trans('narsil::tables.blocks')),
            new MenuItem()
                ->setGroup($group)
                ->setHref(route('fields.index'))
                ->setIcon('input')
                ->setLabel(trans('narsil::tables.fields')),
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
                ->setGroup($group)
                ->setHref(route('graphiql'))
                ->setIcon('braces')
                ->setLabel(trans('narsil::ui.graphiql'))
                ->setTarget('_blank'),
        ];
    }

    #endregion
}
