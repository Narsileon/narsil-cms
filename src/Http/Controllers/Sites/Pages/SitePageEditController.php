<?php

namespace Narsil\Http\Controllers\Sites\Pages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\SitePageForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param SitePage $sitePage
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $site, SitePage $sitePage): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $sitePage);

        $data = $this->getData($sitePage);
        $form = $this->getForm($site, $sitePage);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param SitePage $sitePage
     *
     * @return array<string,mixed>
     */
    protected function getData(SitePage $sitePage): array
    {
        $data = $sitePage->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . SitePage::class);
    }

    /**
     * Get the associated form.
     *
     * @param string $site
     * @param SitePage $sitePage
     *
     * @return SitePageForm
     */
    protected function getForm(string $site, SitePage $sitePage): SitePageForm
    {
        $form = app(SitePageForm::class)
            ->action(route('sites.pages.update', [
                'sitePage' => $sitePage->{SitePage::ID},
                'site' => $site,
            ]))
            ->id($sitePage->{SitePage::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . SitePage::class);
    }

    #endregion
}
