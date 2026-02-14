<?php

namespace Narsil\Cms\Http\Controllers\Storages\Assets;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Implementations\Forms\AssetForm;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Asset $asset
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Asset $asset): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::UPDATE, $asset);

        $data = $this->getData($asset);
        $form = $this->getForm($asset);

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
     * @param Asset $asset
     *
     * @return array<string,mixed>
     */
    protected function getData(Asset $asset): array
    {
        $data = $asset->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Asset::TABLE);
    }

    /**
     * Get the associated form.
     *
     * @param Asset $asset
     *
     * @return AssetForm
     */
    protected function getForm(Asset $asset): AssetForm
    {
        $form = app(AssetForm::class)
            ->action(route('assets.store', [
                'id' => $asset->{Asset::UUID},
            ]))
            ->id($asset->{Asset::UUID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-ui::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Asset::TABLE);
    }

    #endregion
}
