<?php

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\LiveEditor\LiveEditorSessionService;

#endregion

/**
 * @author Jonathan Rigaux
 */
class LiveEditorShowController extends RenderController
{
    #region CONSTANTS

    /**
     * The placeholder the client swaps for the uuid of a node.
     *
     * @var string
     */
    final public const NODE_PLACEHOLDER = '__NODE_UUID__';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     *
     * @return JsonResponse|Response
     */
    public function __invoke(SitePage $sitePage): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $this->registerTranslations();

        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($sitePage);

        return $this->render('narsil/cms::live-editor/index', [
            ...$bootstrap,
            'routes' => $this->getRoutes($sitePage),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::live_editor.description');
    }

    /**
     * Get the endpoints the editor talks to.
     *
     * @param SitePage $sitePage
     *
     * @return array
     */
    protected function getRoutes(SitePage $sitePage): array
    {
        $node = [
            'nodeUuid' => self::NODE_PLACEHOLDER,
            'sitePage' => $sitePage->{SitePage::ID},
        ];

        $page = [
            'sitePage' => $sitePage->{SitePage::ID},
        ];

        return [
            'nodeDestroy' => route('live-editor.nodes.destroy', $node),
            'nodeForm' => route('live-editor.nodes.form', $node),
            'nodeReorder' => route('live-editor.nodes.reorder', $page),
            'nodeStore' => route('live-editor.nodes.store', $page),
            'nodeUpdate' => route('live-editor.nodes.update', $node),
            'sitePages' => route('sites.edit', [
                'site' => $sitePage->{SitePage::RELATION_SITE}?->getRouteKey(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::live_editor.title');
    }

    /**
     * @return void
     */
    protected function registerTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::live_editor.inspector.empty')
            ->add('narsil-cms::live_editor.inspector.title')
            ->add('narsil-cms::live_editor.preview.missing')
            ->add('narsil-cms::live_editor.preview.title')
            ->add('narsil-cms::live_editor.title')
            ->add('narsil-cms::live_editor.tree.add')
            ->add('narsil-cms::live_editor.tree.empty')
            ->add('narsil-cms::live_editor.tree.title')
            ->add('narsil::ui.cancel')
            ->add('narsil::ui.close')
            ->add('narsil::ui.confirm')
            ->add('narsil::ui.default')
            ->add('narsil::ui.delete')
            ->add('narsil::ui.move')
            ->add('narsil::ui.save')
            ->add('narsil::ui.translations');
    }

    #endregion
}
