<?php

namespace Narsil\Http\Controllers\Templates;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\TemplateForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateEditController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Template $template): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $template);

        $data = $this->getData($template);
        $form = $this->getForm($template)
            ->setData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Template $template
     *
     * @return array<string,mixed>
     */
    protected function getData(Template $template): array
    {
        $data = $template->toArrayWithTranslations();

        return $data;
    }

    /**
     * Get the associated form.
     *
     * @param Template $template
     *
     * @return TemplateForm
     */
    protected function getForm(Template $template): TemplateForm
    {
        $form = app(TemplateForm::class)
            ->setAction(route('templates.update', $template->{Template::ID}))
            ->setId($template->{Template::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
