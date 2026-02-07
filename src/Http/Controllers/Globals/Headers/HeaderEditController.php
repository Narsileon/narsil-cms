<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\HeaderForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Header $header
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Header $header): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $header);

        $data = $this->getData($header);
        $form = $this->getForm($header);

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
     * @param Header $header
     *
     * @return array<string,mixed>
     */
    protected function getData(Header $header): array
    {
        $header->loadMissingCreatorAndEditor();

        $header->mergeCasts([
            Header::CREATED_AT => HumanDatetimeCast::class,
            Header::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $header->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Header::class);
    }

    /**
     * Get the associated form.
     *
     * @param Header $header
     *
     * @return HeaderForm
     */
    protected function getForm(Header $header): HeaderForm
    {
        $form = app(HeaderForm::class, ['model' => $header])
            ->action(route('headers.update', $header->{Header::ID}))
            ->id($header->{Header::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-cms::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Header::class);
    }

    #endregion
}
