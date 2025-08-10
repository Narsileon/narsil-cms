<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\FormRequests\TemplateFormRequest;
use Narsil\Contracts\Forms\TemplateForm;
use Narsil\Contracts\Tables\TemplateTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

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
        $this->authorize(PermissionEnum::VIEW_ANY, Template::class);

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
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $this->form->method = MethodEnum::POST;
        $this->form->url = route('templates.store');

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
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template = Template::create($attributes);

        $this->syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

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
        $this->authorize(PermissionEnum::UPDATE, $template);

        $this->form->method = MethodEnum::PATCH;
        $this->form->url = route('templates.update', [
            Str::singular(Template::TABLE) => $template->{Template::ID}
        ]);

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
        $this->authorize(PermissionEnum::UPDATE, $template);

        $data = $request->all();
        $rules = $this->formRequest->rules($template);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template->update($attributes);

        $this->syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

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
        $this->authorize(PermissionEnum::DELETE, $template);

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
        $this->authorize(PermissionEnum::DELETE_ANY, Template::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Template::whereIn(Template::ID, $ids)->delete();

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil-cms::toasts.success.templates.deleted_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param TemplateSection $templateSection
     * @param array $elements
     *
     * @return void
     */
    protected function syncElements(TemplateSection $templateSection, array $elements): void
    {
        $templateSection->blocks()->detach();
        $templateSection->fields()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, TemplateSectionElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                TemplateSectionElement::HANDLE => Arr::get($element, TemplateSectionElement::HANDLE),
                TemplateSectionElement::NAME => Arr::get($element, TemplateSectionElement::NAME),
                TemplateSectionElement::POSITION => $position,
                TemplateSectionElement::WIDTH => Arr::get($element, TemplateSectionElement::WIDTH),
            ];

            match ($table)
            {
                Block::TABLE => $templateSection->blocks()->attach($id, $attributes),
                Field::TABLE => $templateSection->fields()->attach($id, $attributes),
                default => null,
            };
        }
    }

    /**
     * @param Template $block
     * @param array $sections
     *
     * @return void
     */
    protected function syncSections(Template $template, array $sections): void
    {
        $ids = [];

        foreach ($sections as $key => $section)
        {
            $templateSection = TemplateSection::updateOrCreate([
                TemplateSection::TEMPLATE_ID => $template->{Template::ID},
                TemplateSection::HANDLE => $section[TemplateSection::HANDLE],
            ], [
                TemplateSection::POSITION => $key,
                TemplateSection::NAME => $section[TemplateSection::NAME],
            ]);

            $this->syncElements($templateSection, Arr::get($section, TemplateSection::RELATION_ELEMENTS, []));

            $ids[] = $templateSection->{TemplateSection::ID};
        }

        $template->sections()
            ->whereNotIn(TemplateSection::ID, $ids)
            ->delete();
    }

    #endregion
}
