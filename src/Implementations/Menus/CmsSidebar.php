<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\Menu;
use Narsil\Base\Services\DatabaseService;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\PermissionService;
use Narsil\Base\Support\MenuItem;
use Narsil\Cms\Contracts\Menus\CmsSidebar as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Redirect;
use Narsil\Cms\Models\Sites\Site;

#endregion

final class CmsSidebar extends Menu implements Contract
{
    #region PROTECTED METHODS

    /**
     * @return void
     */
    protected function addCollectionsGroup(): void
    {
        $group = trans('narsil-cms::ui.collections');

        $templates = Template::query()
            ->orderBy(Template::PLURAL)
            ->get();

        foreach ($templates as $template)
        {
            $this->add(
                new MenuItem($template->{Template::TABLE_NAME})
                    ->group($group)
                    ->icon('fa-solid-layer-group')
                    ->label($template->{Template::PLURAL})
                    ->route('collections.index')
                    ->parameters([
                        'collection' => $template->{Template::TABLE_NAME},
                    ])
                    ->permissions([
                        PermissionService::getName(Entity::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            );
        }
    }

    /**
     * @return void
     */
    protected function addGlobalsGroup(): void
    {
        $group = trans('narsil-cms::ui.globals');

        $this
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Header::TABLE))
                    ->group($group)
                    ->icon('fa-solid-header')
                    ->label(ModelService::getTableLabel(Header::TABLE))
                    ->route('headers.index')
                    ->permissions([
                        PermissionService::getName(Header::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            )
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Footer::TABLE))
                    ->group($group)
                    ->icon('fa-solid-window-maximize')
                    ->label(ModelService::getTableLabel(Footer::TABLE))
                    ->route('footers.index')
                    ->permissions([
                        PermissionService::getName(Footer::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            );
    }

    /**
     * @return void
     */
    protected function addManagementGroup(): void
    {
        $group = trans('narsil::ui.management');

        $this
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Host::TABLE))
                    ->group($group)
                    ->icon('fa-solid-server')
                    ->label(ModelService::getTableLabel(Host::TABLE))
                    ->route('hosts.index')
                    ->permissions([
                        PermissionService::getName(Host::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            )
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Redirect::TABLE))
                    ->group($group)
                    ->icon('fa-solid-redo')
                    ->label(ModelService::getTableLabel(Redirect::TABLE))
                    ->route('redirects.index')
                    ->permissions([
                        PermissionService::getName(Redirect::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            );
    }

    /**
     * @return void
     */
    protected function addSiteGroup(): void
    {
        $group = ModelService::getTableLabel(Site::VIRTUAL_TABLE);

        $sites = Site::query()
            ->orderBy(Site::LABEL)
            ->get();

        foreach ($sites as $site)
        {
            $this->add(
                new MenuItem($site->{Site::HOSTNAME})
                    ->group($group)
                    ->icon('fa-solid-globe')
                    ->label($site->{Site::LABEL}, false)
                    ->route('sites.edit')
                    ->parameters([
                        'country' => HostLocale::COUNTRY_DEFAULT,
                        'site' => $site->{Site::HOSTNAME},
                    ])
                    ->permissions([
                        PermissionService::getName(Site::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            );
        }
    }

    /**
     * @return void
     */
    protected function addStructuresGroup(): void
    {
        $group = trans('narsil-cms::ui.structures');

        $this
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Template::TABLE))
                    ->group($group)
                    ->icon('fa-solid-window-restore')
                    ->label(ModelService::getTableLabel(Template::TABLE))
                    ->route('templates.index')
                    ->permissions([
                        PermissionService::getName(Template::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            )
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Block::TABLE))
                    ->group($group)
                    ->icon('fa-solid-cubes-stacked')
                    ->label(ModelService::getTableLabel(Block::TABLE))
                    ->route('blocks.index')
                    ->permissions([
                        PermissionService::getName(Block::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            )
            ->add(
                new MenuItem(DatabaseService::getUnqualifiedTableName(Field::TABLE))
                    ->group($group)
                    ->icon('fa-solid-list')
                    ->label(ModelService::getTableLabel(Field::TABLE))
                    ->route('fields.index')
                    ->permissions([
                        PermissionService::getName(Field::TABLE, AbilityEnum::VIEW_ANY),
                    ])
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        $this
            ->add(
                new MenuItem('dashboard')
                    ->icon('fa-solid-chart-pie')
                    ->label(trans('narsil-cms::ui.dashboard'))
                    ->route('dashboard')
            );

        $this->addSiteGroup();
        $this->addGlobalsGroup();
        $this->addCollectionsGroup();
        $this->addStructuresGroup();
        $this->addManagementGroup();

        return parent::content();
    }

    #endregion
}
