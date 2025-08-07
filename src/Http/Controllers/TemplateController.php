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
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Template;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateController extends AbstractController
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
        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $this->form->jsonSerialize(),
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

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil-cms::toasts.success.templates.created'));
    }

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Template $template): JsonResponse|Response
    {
        $this->form
            ->method(MethodEnum::PATCH)
            ->submit(trans('narsil-cms::ui.update'))
            ->url(route('templates.update', $template->{Template::ID}));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $template,
            ]),
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

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil-cms::toasts.success.templates.updated'));
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

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil-cms::toasts.success.templates.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $ids = $request->validated(DestroyManyRequest::IDS);

        Template::whereIn(Template::ID, $ids)->delete();

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil-cms::toasts.success.templates.deleted_many'));
    }

    #endregion
}
