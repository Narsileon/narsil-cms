<?php

namespace Narsil\Http\Controllers\Footers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\FooterForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Globals\Footer;

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
        $form = $this->getForm($footer)
            ->formData($data);

        return $this->render('narsil/cms::resources/form', [
            'form' => $form->jsonSerialize(),
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
        return trans('narsil::models.' . Footer::class);
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
        $form = app(FooterForm::class)
            ->action(route('footers.update', $footer->{Footer::ID}))
            ->id($footer->{Footer::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . Footer::class);
    }

    #endregion
}
