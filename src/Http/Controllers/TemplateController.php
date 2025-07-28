<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Contracts\Forms\TemplateForm;
use Narsil\Contracts\Tables\TemplateTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTable\DataTableCollection;
use Narsil\Models\Templates\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateController extends AbstractResourceController
{
    #region CONSTRUCTOR

    /**
     * @param TemplateForm $form
     * @param TemplateFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(TemplateForm $form, TemplateFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var TemplateForm
     */
    protected readonly TemplateForm $form;
    /**
     * @var TemplateFormRequest
     */
    protected readonly TemplateFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = Template::query();

        $dataTable = new DataTableCollection($query, app(TemplateTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.templates'),
            description: trans('narsil-cms::ui.templates'),
            props: [
                'dataTable' => $dataTable,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function create(Request $request): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('templates.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.template'),
            description: trans('narsil-cms::ui.template'),
            props: [
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        Template::create($attributes);

        return $this->redirectOnStored(Template::TABLE);
    }

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Template $template): JsonResponse|Response
    {
        $form = $this->form->get(
            url: route('templates.update', $template->{Template::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.template'),
            description: trans('narsil-cms::ui.template'),
            props: [
                'data' => $template,
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Template $template): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $template->update($attributes);

        return $this->redirectOnUpdated(Template::TABLE);
    }

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Template $template): RedirectResponse
    {
        $template->delete();

        return $this->redirectOnDestroyed(Template::TABLE);
    }

    #endregion
}
