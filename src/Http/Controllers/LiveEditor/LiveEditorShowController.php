<?php

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Base\Support\TranslationsBag;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\LiveEditor\LiveEditorSessionService;

#endregion

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
        $sitePage = $this->resolveCountryPage($sitePage);

        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        $this->registerTranslations();

        $bootstrap = app(LiveEditorSessionService::class)->bootstrap($sitePage);

        return $this->render('narsil/cms::live-editor/index', [
            ...$bootstrap,
            'routes' => $this->getRoutes($sitePage),
        ]);
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Resolve the equivalent page for the requested country.
     *
     * @param SitePage $sitePage
     *
     * @return SitePage
     */
    private function resolveCountryPage(SitePage $sitePage): SitePage
    {
        $country = request()->query(SitePage::COUNTRY);
        $page = $sitePage;

        if (is_string($country) && $country !== $sitePage->{SitePage::COUNTRY})
        {
            $slug = $sitePage->getTranslationWithoutFallback(SitePage::SLUG, App::getLocale());

            $page = SitePage::query()
                ->where(SitePage::SITE_ID, $sitePage->{SitePage::SITE_ID})
                ->where(SitePage::COUNTRY, $country)
                ->where(SitePage::SLUG . '->' . App::getLocale(), $slug)
                ->first() ?? $sitePage;
        }

        return $page;
    }

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::live-editor.description');
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
            'pageCreate' => route('sites.pages.create', [
                'site' => $sitePage->{SitePage::RELATION_SITE}?->getRouteKey(),
            ]),
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
        return trans('narsil-cms::live-editor.title');
    }

    /**
     * @return void
     */
    protected function registerTranslations(): void
    {
        app(TranslationsBag::class)
            ->add('narsil-cms::live-editor.inspector.empty')
            ->add('narsil-cms::live-editor.inspector.title')
            ->add('narsil-cms::live-editor.country')
            ->add('narsil-cms::live-editor.language')
            ->add('narsil-cms::live-editor.pages.create')
            ->add('narsil-cms::live-editor.pages.empty')
            ->add('narsil-cms::live-editor.pages.title')
            ->add('narsil-cms::live-editor.preview.missing')
            ->add('narsil-cms::live-editor.preview.title')
            ->add('narsil-cms::live-editor.title')
            ->add('narsil-cms::live-editor.tree.add')
            ->add('narsil-cms::live-editor.tree.empty')
            ->add('narsil-cms::live-editor.tree.title')
            ->add('narsil-cms::live-editor.workspace')
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
