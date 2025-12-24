<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\SitePageForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Sites\SitePage;
use Narsil\Services\ModelService;

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
            ->submitLabel(trans('narsil::ui.save'));

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
