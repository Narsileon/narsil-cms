<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers\LiveEditor;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

class LiveEditorShowController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param SitePage $sitePage
     *
     * @return JsonResponse|View
     */
    public function __invoke(SitePage $sitePage): View
    {
        $sitePage = $this->resolveCountryPage($sitePage);

        $this->authorize(AbilityEnum::UPDATE, $sitePage);

        return $this->renderBlade('narsil-cms::live-editor.index', [
            'sitePage' => $sitePage,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil-cms::live-editor.description');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::live-editor.title');
    }

    #endregion

    #region PRIVATE METHODS

    /**
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

    #endregion
}
