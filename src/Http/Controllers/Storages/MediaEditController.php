<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Implementations\Forms\MediaForm;
use Narsil\Models\Storages\Media;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $disk
     * @param Media $media
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $disk, Media $media): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $media);

        $data = $this->getData($media);
        $form = $this->getForm($media);

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
     * @param Media $media
     *
     * @return array<string,mixed>
     */
    protected function getData(Media $media): array
    {
        $data = $media->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        $disk = request('disk');

        return ModelService::getModelLabel($disk);
    }

    /**
     * Get the associated form.
     *
     * @param Media $media
     *
     * @return MediaForm
     */
    protected function getForm(Media $media): MediaForm
    {
        $disk = request('disk');

        $form = app(MediaForm::class, [
            'disk' => $disk,
        ])
            ->action(route('media.store', [
                'id' => $media->{Media::UUID},
                'disk' => $disk,
            ]))
            ->id($media->{Media::UUID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        $disk = request('disk');

        return ModelService::getModelLabel($disk);
    }

    #endregion
}
