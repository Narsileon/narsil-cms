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
use Narsil\Models\Sites\SitePageEntity;
use Narsil\Services\ModelService;

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

        $this->transformEntities($sitePage);

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
        return ModelService::getModelLabel(SitePage::class);
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
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(SitePage::class);
    }

    /**
     * Transform the entities for the form.
     *
     * @param SitePage $sitePage
     *
     * @return void
     */
    protected function transformEntities(SitePage $sitePage): void
    {
        $entities = $sitePage->{SitePage::RELATION_ENTITIES}
            ->mapWithKeys(function ($entity)
            {
                return [
                    $entity->{SitePageEntity::LANGUAGE} => $entity->{SitePageEntity::TARGET_TYPE} . '-' . $entity->{SitePageEntity::TARGET_ID},
                ];
            });

        $sitePage->setRelation(SitePage::RELATION_ENTITIES, $entities);
    }

    #endregion
}
