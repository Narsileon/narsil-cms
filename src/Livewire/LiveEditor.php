<?php

declare(strict_types=1);

namespace Narsil\Cms\Livewire;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Narsil\Base\Contracts\Menus\AuthMenu;
use Narsil\Base\Contracts\Menus\GuestMenu;
use Narsil\Base\Contracts\Menus\Home;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Cms\Contracts\Actions\LiveEditor\CreateEntityBlockNode;
use Narsil\Cms\Contracts\Actions\LiveEditor\DeleteEntityNode;
use Narsil\Cms\Contracts\Actions\LiveEditor\ReorderEntityNodes;
use Narsil\Cms\Contracts\Actions\LiveEditor\UpdateEntityNode;
use Narsil\Cms\Contracts\Forms\LiveEditor\EntityNodeInspectorForm;
use Narsil\Cms\Http\Resources\LiveEditor\EntityNodeTreeResource;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\BreadcrumbService;
use Narsil\Cms\Services\LiveEditor\EntityNodeInspectorService;
use Narsil\Cms\Services\LiveEditor\EntityNodeResolver;
use Narsil\Cms\Services\LiveEditor\LiveEditorSessionService;
use Narsil\Cms\Services\Sites\SitePageFormRules;
use Narsil\Cms\Services\Sites\SitePageUpdateService;

#endregion

final class LiveEditor extends Component
{
    /**
     * The block form data currently edited in the inspector.
     *
     * @var array<string,mixed>
     */
    public array $blockData = [];

    /**
     * @var array<int,array<string,mixed>>
     */
    #[Locked]
    public array $breadcrumb = [];

    /**
     * The page form data currently edited in the inspector.
     *
     * @var array<string,mixed>
     */
    public array $pageData = [];

    /**
     * The current URL of the page being edited.
     *
     * @var string
     */
    #[Locked]
    public string $currentUrl = '';

    /**
     * The country currently shown in the preview.
     *
     * @var string
     */
    #[Locked]
    public string $previewCountry = 'default';

    /**
     * The language currently shown in the preview.
     *
     * @var string
     */
    #[Locked]
    public string $previewLanguage = '';

    /**
     * A changing key reloads the preview iframe after saves.
     *
     * @var integer
     */
    public int $previewVersion = 0;

    /**
     * The selected block node UUID.
     *
     * @var string|null
     */
    #[Locked]
    public ?string $selectedNodeId = null;

    /**
     * The site page being edited.
     *
     * @var integer
     */
    #[Locked]
    public int $sitePageId;

    /**
     * @param string $parentUuid
     * @param integer $blockId
     *
     * @return void
     */
    public function addNode(string $parentUuid, int $blockId): void
    {
        $sitePage = $this->getSitePage();
        $entity = $this->getEntity($sitePage);
        $parent = $this->getNode($entity, $parentUuid);
        $parentTree = $this->findTreeNode($this->getTree($entity), $parentUuid);

        abort_unless(
            $parentTree && $parentTree['type'] === 'builder',
            422,
            'Blocks can only be added to a builder.',
        );

        $allowedBlockIds = array_map(
            function (array $block): int
            {
                return (int) $block['block_id'];
            },
            $parentTree['allowedBlocks'],
        );

        abort_unless(in_array($blockId, $allowedBlockIds, true), 422);

        $node = app(CreateEntityBlockNode::class)->run($parent, $blockId);

        $this->selectNode($node->{EntityNode::UUID});
        $this->previewVersion++;
    }

    /**
     * @param string $country
     *
     * @return void
     */
    public function changeCountry(string $country): void
    {
        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($this->getSitePage(), $this->previewCountry);
        $countries = array_map(
            function (mixed $option): string
            {
                return (string) data_get($option, 'value', '');
            },
            $bootstrap['countries'],
        );

        abort_unless(in_array($country, $countries, true), 422);

        $this->redirect(route('live-editor.show', [
            'sitePage' => $this->sitePageId,
            SitePage::COUNTRY => $country,
        ]));
    }

    /**
     * @param string $language
     *
     * @return void
     */
    public function changeLanguage(string $language): void
    {
        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($this->getSitePage(), $this->previewCountry);
        $languages = array_map(
            function (mixed $option): string
            {
                return (string) data_get($option, 'value', '');
            },
            data_get($bootstrap['pageForm'], 'languages', []),
        );

        abort_unless(in_array($language, $languages, true), 422);

        $this->previewLanguage = $language;
    }

    /**
     * @param string $nodeUuid
     *
     * @return void
     */
    public function deleteNode(string $nodeUuid): void
    {
        $sitePage = $this->getSitePage();
        $entity = $this->getEntity($sitePage);
        $node = $this->getNode($entity, $nodeUuid);

        abort_unless($node->{EntityNode::BLOCK_ID}, 422);

        app(DeleteEntityNode::class)->run($node);

        if ($this->selectedNodeId === $nodeUuid)
        {
            $this->selectedNodeId = null;
            $this->blockData = [];
        }

        $this->previewVersion++;
    }

    /**
     * @param SitePage $sitePage
     *
     * @return void
     */
    public function mount(SitePage $sitePage): void
    {
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $this->sitePageId = (int) $sitePage->getKey();
        $this->breadcrumb = BreadcrumbService::getBreadcrumbs(request());
        $this->currentUrl = url()->current();

        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($sitePage);

        $this->pageData = $bootstrap['pageData'];
        $this->previewCountry = (string) $bootstrap['country'];
        $this->previewLanguage = (string) $bootstrap['locale'];
    }

    /**
     * @return View
     */
    public function render(): View
    {
        $sitePage = $this->getSitePage();
        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($sitePage, $this->previewCountry);
        $bootstrap['pages'] = $this->getPageTree($bootstrap['pages']);
        $bootstrap['tree'] = $this->getTree($this->resolveEntity($sitePage));
        $bootstrap['previewUrl'] = $this->getPreviewUrl($bootstrap['previewUrl']);
        $inspector = $this->getInspector($sitePage);

        return view('narsil-cms::components.blocks.live-editor.live-editor-root', [
            'auth' => Auth::user(),
            'bootstrap' => $bootstrap,
            'breadcrumb' => $this->breadcrumb,
            'currentUrl' => $this->currentUrl,
            'home' => app(Home::class)->jsonSerialize(),
            'inspector' => $inspector,
            'menu' => app(Auth::check() ? AuthMenu::class : GuestMenu::class)->jsonSerialize(),
        ]);
    }

    /**
     * @param array<int,string> $orderedUuids
     * @param string $parentUuid
     *
     * @return void
     */
    public function reorderNodes(string $parentUuid, array $orderedUuids): void
    {
        $sitePage = $this->getSitePage();
        $entity = $this->getEntity($sitePage);
        $parent = $this->getNode($entity, $parentUuid);
        $parentTree = $this->findTreeNode($this->getTree($entity), $parentUuid);

        abort_unless(
            $parentTree && $parentTree['type'] === 'builder',
            422,
            'Only builder nodes can be reordered.',
        );

        $currentUuids = array_map(
            function (array $node): string
            {
                return (string) $node['id'];
            },
            $parentTree['children'],
        );
        $submittedUuids = $orderedUuids;
        $expectedUuids = $currentUuids;

        sort($expectedUuids);
        sort($submittedUuids);

        abort_unless($expectedUuids === $submittedUuids, 422);

        app(ReorderEntityNodes::class)->run($parent, $orderedUuids);

        $this->previewVersion++;
    }

    /**
     * @return void
     */
    public function saveNode(): void
    {
        $sitePage = $this->getSitePage();
        $entity = $this->getEntity($sitePage);

        abort_unless($this->selectedNodeId, 404);

        $node = $this->getNode($entity, $this->selectedNodeId);

        abort_unless($node->{EntityNode::BLOCK_ID}, 422);

        $validated = Validator::make([
            'blockData' => $this->blockData,
        ], [
            'blockData' => ['array'],
        ])->validate();
        $attributes = Arr::get($validated, 'blockData', []);

        unset($attributes[EntityNode::ACTIVE]);

        app(UpdateEntityNode::class)->run($node, $attributes);

        $this->blockData = app(EntityNodeInspectorService::class)->build($entity, $node->refresh())['data'];
        $this->previewVersion++;
    }

    /**
     * @return void
     */
    public function savePage(): void
    {
        $sitePage = $this->getSitePage();
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $rules = app(SitePageFormRules::class)->forPage($sitePage);
        $pageRules = [];

        foreach ($rules as $key => $rule)
        {
            $pageRules['pageData.' . $key] = $rule;
        }

        $validated = Validator::make([
            'pageData' => $this->pageData,
        ], $pageRules)->validate();
        $attributes = Arr::get($validated, 'pageData', []);
        $attributes[SitePage::SITE_ID] = $sitePage->{SitePage::SITE_ID};

        $sitePage = app(SitePageUpdateService::class)->update($sitePage, $attributes);
        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($sitePage, $this->previewCountry);

        $this->pageData = $bootstrap['pageData'];
        $this->previewVersion++;
    }

    /**
     * @param string $nodeUuid
     *
     * @return void
     */
    public function selectNode(string $nodeUuid): void
    {
        $entity = $this->getEntity($this->getSitePage());
        $node = $this->getNode($entity, $nodeUuid);

        abort_unless($node->{EntityNode::BLOCK_ID}, 422);

        $inspector = app(EntityNodeInspectorService::class)->build($entity, $node);

        $this->selectedNodeId = $nodeUuid;
        $this->blockData = $inspector['data'];
        $this->dispatch('narsil-live-editor-node-selected', nodeId: $nodeUuid);
    }

    /**
     * @param array<int,array<string,mixed>> $tree
     * @param string $nodeUuid
     *
     * @return array<string,mixed>|null
     */
    private function findTreeNode(array $tree, string $nodeUuid): ?array
    {
        foreach ($tree as $node)
        {
            if (($node['id'] ?? null) === $nodeUuid)
            {
                return $node;
            }

            $found = $this->findTreeNode($node['children'] ?? [], $nodeUuid);

            if ($found)
            {
                return $found;
            }
        }

        return null;
    }

    /**
     * @param SitePage $sitePage
     *
     * @return Entity
     */
    private function getEntity(SitePage $sitePage): Entity
    {
        $entity = $this->resolveEntity($sitePage);

        abort_unless($entity, 404);

        $entity->{Entity::RELATION_NODES}->loadMissing([
            EntityNode::RELATION_BLOCK,
            EntityNode::RELATION_ELEMENT,
            EntityNode::RELATION_RELATIONS,
        ]);

        return $entity;
    }

    /**
     * @param SitePage $sitePage
     *
     * @return array<string,mixed>|null
     */
    private function getInspector(SitePage $sitePage): ?array
    {
        if (!$this->selectedNodeId)
        {
            return null;
        }

        $entity = $this->resolveEntity($sitePage);

        if (!$entity)
        {
            $this->selectedNodeId = null;

            return null;
        }

        $node = app(EntityNodeResolver::class)->resolveNode($entity, $this->selectedNodeId);

        if (!$node || !$node->{EntityNode::BLOCK_ID})
        {
            $this->selectedNodeId = null;
            $this->blockData = [];

            return null;
        }

        $inspector = app(EntityNodeInspectorService::class)->build($entity, $node);
        $form = app()->make(EntityNodeInspectorForm::class, [
            'elements' => $inspector['elements'],
        ])
            ->action('#')
            ->autoSave(false)
            ->id($inspector['nodeUuid'])
            ->defaultLanguage(HostLocaleLanguage::getDefaultLanguage())
            ->languages(HostLocaleLanguage::getUniqueLanguages())
            ->method(RequestMethodEnum::PATCH->value)
            ->options($inspector['options'])
            ->submitLabel(trans('narsil::ui.save'));

        return [
            'form' => $form,
            'label' => $inspector['label'],
            'nodeUuid' => $inspector['nodeUuid'],
            'options' => $inspector['options'],
        ];
    }

    /**
     * @param Entity $entity
     * @param string $nodeUuid
     *
     * @return EntityNode
     */
    private function getNode(Entity $entity, string $nodeUuid): EntityNode
    {
        $node = app(EntityNodeResolver::class)->resolveNode($entity, $nodeUuid);

        abort_unless($node, 404);

        return $node;
    }

    /**
     * @param array<int,array<string,mixed>> $pages
     *
     * @return array<int,array<string,mixed>>
     */
    private function getPageTree(array $pages): array
    {
        foreach ($pages as $index => $page)
        {
            if (isset($page['label']) && is_array($page['label']))
            {
                $labels = $page['label'];
                $pages[$index]['label'] = $labels[app()->getLocale()] ?? (array_values($labels)[0] ?? '');
            }

            if (isset($page['live_editor_url']))
            {
                $pages[$index]['live_editor_url'] = $this->getPageUrl($page['live_editor_url']);
            }

            if (isset($page['children']) && is_array($page['children']))
            {
                $pages[$index]['children'] = $this->getPageTree($page['children']);
            }
        }

        return $pages;
    }

    /**
     * @param string $url
     *
     * @return string
     */
    private function getPageUrl(string $url): string
    {
        $parts = parse_url($url);

        if (!is_array($parts))
        {
            return $url;
        }

        $query = [];

        if (isset($parts['query']))
        {
            parse_str($parts['query'], $query);
        }

        $query[SitePage::COUNTRY] = $this->previewCountry;

        $resolvedUrl = '';

        if (isset($parts['scheme'], $parts['host']))
        {
            $resolvedUrl = $parts['scheme'] . '://' . $parts['host'];

            if (isset($parts['port']))
            {
                $resolvedUrl .= ':' . $parts['port'];
            }
        }

        $resolvedUrl .= $parts['path'] ?? '';
        $resolvedUrl .= '?' . http_build_query($query);

        if (isset($parts['fragment']))
        {
            $resolvedUrl .= '#' . $parts['fragment'];
        }

        return $resolvedUrl;
    }

    /**
     * @param string|null $previewUrl
     *
     * @return string|null
     */
    private function getPreviewUrl(?string $previewUrl): ?string
    {
        if (!$previewUrl)
        {
            return null;
        }

        $parts = parse_url($previewUrl);
        $query = [];

        if (isset($parts['query']))
        {
            parse_str($parts['query'], $query);
        }

        $query['_country'] = $this->previewCountry;
        $query['_preview_language'] = $this->previewLanguage;

        $url = '';

        if (isset($parts['scheme'], $parts['host']))
        {
            $url = $parts['scheme'] . '://' . $parts['host'];

            if (isset($parts['port']))
            {
                $url .= ':' . $parts['port'];
            }
        }

        $url .= $parts['path'] ?? '';

        if ($query)
        {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    /**
     * @return SitePage
     */
    private function getSitePage(): SitePage
    {
        $sitePage = SitePage::query()->findOrFail($this->sitePageId);

        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        return $sitePage;
    }

    /**
     * @param Entity|null $entity
     *
     * @return array<int,array<string,mixed>>
     */
    private function getTree(?Entity $entity): array
    {
        if (!$entity)
        {
            return [];
        }

        return (new EntityNodeTreeResource($entity))->resolve();
    }

    /**
     * @param SitePage $sitePage
     *
     * @return Entity|null
     */
    private function resolveEntity(SitePage $sitePage): ?Entity
    {
        return app(EntityNodeResolver::class)->resolveEntity($sitePage);
    }
}
