<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Menus;

#region USE

use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\Menu;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\PermissionService;
use Narsil\Base\Support\MenuItem;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Contracts\Menus\CmsSidebar as Contract;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;

#endregion

final class CmsSidebar extends Menu implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::accessibility.close_sidebar')
            ->add('narsil-cms::accessibility.open_sidebar')
            ->add('narsil-cms::accessibility.toggle_sidebar');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        $this
            ->add(
                new MenuItem('dashboard')
                    ->icon('chart-pie')
                    ->label(trans('narsil-cms::ui.dashboard'))
                    ->route('dashboard')
            );

        $this->addSiteGroup();
        $this->addGlobalsGroup();
        $this->addCollectionsGroup();
        $this->addStructuresGroup();
        $this->addManagementGroup();

        app(TranslationsBag::class)
            ->add('narsil-cms::accessibility.close_sidebar')
            ->add('narsil-cms::accessibility.open_sidebar')
            ->add('narsil-cms::accessibility.toggle_sidebar');

        return parent::content();
    }

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
                    ->icon('layers')
                    ->label($template->{Template::PLURAL})
                    ->route('collections.index')
                    ->parameters([
                        'collection' => $template->{Template::TABLE_NAME},
                    ])
                    ->permissions([
                        PermissionService::getName(Entity::TABLE, AbilityEnum::VIEW_ANY)
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
                new MenuItem(Header::TABLE)
                    ->group($group)
                    ->icon('header')
                    ->label(ModelService::getTableLabel(Header::TABLE))
                    ->route('headers.index')
                    ->permissions([
                        PermissionService::getName(Header::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            )
            ->add(
                new MenuItem(Footer::TABLE)
                    ->group($group)
                    ->icon('footer')
                    ->label(ModelService::getTableLabel(Footer::TABLE))
                    ->route('footers.index')
                    ->permissions([
                        PermissionService::getName(Footer::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            )
        ;
    }

    /**
     * @return void
     */
    protected function addManagementGroup(): void
    {
        $group = trans('narsil::ui.management');

        $this
            ->add(
                new MenuItem(Host::TABLE)
                    ->group($group)
                    ->icon('server')
                    ->label(ModelService::getTableLabel(Host::TABLE))
                    ->route('hosts.index')
                    ->permissions([
                        PermissionService::getName(Host::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            )
            ->add(
                new MenuItem(Configuration::TABLE)
                    ->group($group)
                    ->icon('settings')
                    ->label(ModelService::getTableLabel(Configuration::TABLE))
                    ->route('settings.edit')
                    ->permissions([
                        PermissionService::getName(Configuration::TABLE, AbilityEnum::UPDATE)
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
                    ->icon('globe')
                    ->label($site->{Site::LABEL}, false)
                    ->route('sites.edit')
                    ->parameters([
                        'country' => 'default',
                        'site' => $site->{Site::HOSTNAME},
                    ])
                    ->permissions([
                        PermissionService::getName(Site::TABLE, AbilityEnum::VIEW_ANY)
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
                new MenuItem(Template::TABLE)
                    ->group($group)
                    ->icon('template')
                    ->label(ModelService::getTableLabel(Template::TABLE))
                    ->route('templates.index')
                    ->permissions([
                        PermissionService::getName(Template::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            )
            ->add(
                new MenuItem(Block::TABLE)
                    ->group($group)
                    ->icon('block')
                    ->label(ModelService::getTableLabel(Block::TABLE))
                    ->route('blocks.index')
                    ->permissions([
                        PermissionService::getName(Block::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            )
            ->add(
                new MenuItem(Field::TABLE)
                    ->group($group)
                    ->icon('field')
                    ->label(ModelService::getTableLabel(Field::TABLE))
                    ->route('fields.index')
                    ->permissions([
                        PermissionService::getName(Field::TABLE, AbilityEnum::VIEW_ANY)
                    ])
            );
    }

    #endregion
}
