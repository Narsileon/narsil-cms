<?php

namespace Narsil\Implementations\Menus;

#region USE

use Narsil\Contracts\Menus\Sidebar as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractMenu;
use Narsil\Models\Configuration;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\User;
use Narsil\Services\PermissionService;
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
        $menuItems = array_merge(
            [
                new MenuItem()
                    ->href(route('dashboard'))
                    ->icon('chart-pie')
                    ->label(trans('narsil::ui.dashboard')),
            ],
            $this->getSiteGroup(),
            $this->getCollectionGroup(),
            $this->getGlobalsGroup(),
            $this->getStructuresGroup(),
            $this->getManagementGroup(),
            $this->getToolsGroup(),
        );

        $filteredMenuItems = MenuItem::filterByPermissions(collect($menuItems));

        return $filteredMenuItems->all();
    }

    /**
     * @return array<MenuItem>
     */
    protected function getCollectionGroup(): array
    {
        $menuItems = [];

        $group = trans('narsil::ui.collections');

        $templates = Template::query()
            ->orderBy(Template::PLURAL)
            ->get();

        foreach ($templates as $template)
        {
            $menuItems[] = new MenuItem()
                ->group($group)
                ->href(route('collections.index', [
                    'collection' => $template->{Template::HANDLE},
                ]))
                ->icon('layers')
                ->label($template->{Template::PLURAL})
                ->permissions([
                    PermissionService::getHandle(Entity::TABLE, PermissionEnum::VIEW_ANY->value)
                ]);
        }

        return $menuItems;
    }

    /**
     * @return array<MenuItem>
     */
    protected function getGlobalsGroup(): array
    {
        $group = trans('narsil::ui.globals');

        return [
            new MenuItem()
                ->group($group)
                ->href(route('headers.index'))
                ->icon('header')
                ->label(trans('narsil::tables.headers'))
                ->permissions([
                    PermissionService::getHandle(Header::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('footers.index'))
                ->icon('footer')
                ->label(trans('narsil::tables.footers'))
                ->permissions([
                    PermissionService::getHandle(Footer::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
        ];
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
                ->label(trans('narsil::tables.hosts'))
                ->permissions([
                    PermissionService::getHandle(Host::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('users.index'))
                ->icon('users')
                ->label(trans('narsil::tables.users'))
                ->permissions([
                    PermissionService::getHandle(User::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('roles.index'))
                ->icon('shield')
                ->label(trans('narsil::tables.roles'))
                ->permissions([
                    PermissionService::getHandle(Role::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('permissions.index'))
                ->icon('lock')
                ->label(trans('narsil::tables.permissions'))
                ->permissions([
                    PermissionService::getHandle(Permission::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('settings.edit'))
                ->icon('settings')
                ->label(trans('narsil::tables.configurations'))
                ->permissions([
                    PermissionService::getHandle(Configuration::TABLE, PermissionEnum::UPDATE->value)
                ]),
        ];
    }

    /**
     * @return array<MenuItem>
     */
    protected function getSiteGroup(): array
    {
        $menuItems = [];

        $group = trans('narsil::ui.sites');

        $sites = Site::query()
            ->orderBy(Site::NAME)
            ->get();

        foreach ($sites as $site)
        {
            $menuItems[] = new MenuItem()
                ->group($group)
                ->href(route('sites.edit', [
                    'country' => 'default',
                    'site' => $site->{Site::HANDLE}
                ]))
                ->icon('globe')
                ->label($site->{Site::NAME}, false)
                ->permissions([
                    PermissionService::getHandle(Site::TABLE, PermissionEnum::VIEW_ANY->value)
                ]);
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
                ->label(trans('narsil::tables.templates'))
                ->permissions([
                    PermissionService::getHandle(Template::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('blocks.index'))
                ->icon('box')
                ->label(trans('narsil::tables.blocks'))
                ->permissions([
                    PermissionService::getHandle(Block::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
            new MenuItem()
                ->group($group)
                ->href(route('fields.index'))
                ->icon('input')
                ->label(trans('narsil::tables.fields'))
                ->permissions([
                    PermissionService::getHandle(Field::TABLE, PermissionEnum::VIEW_ANY->value)
                ]),
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
                ->label('GraphQL')
                ->target('_blank'),
            new MenuItem()
                ->group($group)
                ->href(route('horizon.index'))
                ->icon('horizon')
                ->label('Horizon')
                ->target('_blank'),
        ];
    }

    #endregion
}
