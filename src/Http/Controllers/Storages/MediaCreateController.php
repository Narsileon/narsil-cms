<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\HostForm;
use Narsil\Contracts\Forms\MediaForm;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Storages\Media;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $disk
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $disk): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Media::class);

        $form = $this->getForm();

        return $this->render('narsil/cms::resources/form', [
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
        $disk = request('disk');

        return ModelService::getModelLabel($disk);
    }

    /**
     * Get the associated form.
     *
     * @return MediaForm
     */
    protected function getForm(): MediaForm
    {
        $disk = request('disk');

        $form = app(MediaForm::class, [
            'disk' => $disk,
        ])
            ->action(route('media.store', [
                'disk' => $disk,
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
        $disk = request('disk');

        return ModelService::getModelLabel($disk);
    }

    #endregion
}
