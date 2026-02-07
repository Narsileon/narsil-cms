<?php

namespace Narsil\Cms\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\SitePageForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $site
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, SitePage::class);

        $data = $request->query();
        $form = $this->getForm($site);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(SitePage::class);
    }

    /**
     * Get the associated form.
     *
     * @param string $site
     *
     * @return SitePageForm
     */
    protected function getForm(string $site): SitePageForm
    {
        $form = app(SitePageForm::class)
            ->action(route('sites.pages.store', [
                'site' => $site,
            ]))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-cms::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(SitePage::class);
    }

    #endregion
}
