<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Contracts\Forms\FooterForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterCreateController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::CREATE, Footer::class);

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
        return ModelService::getModelLabel(Footer::TABLE);
    }

    /**
     * Get the associated form.
     *
     * @return FooterForm
     */
    protected function getForm(): FooterForm
    {
        $form = app(FooterForm::class)
            ->action(route('footers.store'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-cms::ui.save'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Footer::TABLE);
    }

    #endregion
}
