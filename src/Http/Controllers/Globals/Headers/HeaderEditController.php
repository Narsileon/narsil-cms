<?php

namespace Narsil\Cms\Http\Controllers\Globals\Headers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Casts\DiffForHumansCast;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\RequestMethodEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Contracts\Forms\HeaderForm;
use Narsil\Cms\Models\Globals\Header;

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
        $this->authorize(AbilityEnum::UPDATE, $header);

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
            Header::CREATED_AT => DiffForHumansCast::class,
            Header::UPDATED_AT => DiffForHumansCast::class,
        ]);

        $data = $header->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getModelLabel(Header::TABLE);
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
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Header::TABLE);
    }

    #endregion
}
