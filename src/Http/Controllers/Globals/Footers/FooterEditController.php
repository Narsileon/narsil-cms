<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Casts\HumanDatetimeCast;
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
class FooterEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Footer $footer
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Footer $footer): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $footer);

        $data = $this->getData($footer);
        $form = $this->getForm($footer);

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
     * @param Footer $footer
     *
     * @return array<string,mixed>
     */
    protected function getData(Footer $footer): array
    {
        $footer->loadMissingCreatorAndEditor();

        $footer->mergeCasts([
            Footer::CREATED_AT => HumanDatetimeCast::class,
            Footer::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $footer->toArrayWithTranslations();

        return $data;
    }

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
     * @param Footer $footer
     *
     * @return FooterForm
     */
    protected function getForm(Footer $footer): FooterForm
    {
        $form = app(FooterForm::class, ['model' => $footer])
            ->action(route('footers.update', $footer->{Footer::ID}))
            ->id($footer->{Footer::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-cms::ui.update'));

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
