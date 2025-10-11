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
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Services\MigrationService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateController extends AbstractController
{
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

        $collection = new DataTableCollection($query, Template::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.templates'),
            description: trans('narsil::tables.templates'),
            props: [
                'collection' => $collection,
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

        $form = app(TemplateForm::class)
            ->action(route('templates.store'))
            ->method(MethodEnum::POST)
            ->submitLabel(trans('narsil::ui.save'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $rules = app(TemplateFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template = Template::create($attributes);

        $this->syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

        if ($sets = Arr::get($attributes, Template::RELATION_SETS))
        {
            $this->syncSets($template, $sets);
        }

        MigrationService::syncTable($template);

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil::toasts.success.templates.created'));
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

        $form = app(TemplateForm::class)
            ->action(route('templates.update', $template->{Template::ID}))
            ->data($template)
            ->id($template->{Template::ID})
            ->method(MethodEnum::PATCH)
            ->submitLabel(trans('narsil::ui.update'));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
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

        $rules = app(TemplateFormRequest::class)->rules($template);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $template->update($attributes);

        if (Arr::get($data, '_dirty', false))
        {
            $this->syncSections($template, Arr::get($attributes, Template::RELATION_SECTIONS, []));

            if ($sets = Arr::get($attributes, Template::RELATION_SETS))
            {
                $this->syncSets($template, $sets);
            }

            MigrationService::syncTable($template);
        }

        return $this
            ->redirect(route('templates.index'))
            ->with('success', trans('narsil::toasts.success.templates.updated'));
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
            ->with('success', trans('narsil::toasts.success.templates.deleted'));
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
            ->with('success', trans('narsil::toasts.success.templates.deleted_many'));
    }

    /**
     * @param Request $request
     * @param Template $template
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, Template $template): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $this->replicateTemplate($template);

        return back()
            ->with('success', trans('narsil::toasts.success.templates.replicated'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Template::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $templates = Template::query()
            ->findMany($ids);

        foreach ($templates as $template)
        {
            $this->replicateTemplate($template);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.templates.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    protected function replicateTemplate(Template $template): void
    {
        $replicated = $template->replicate();

        $replicated
            ->fill([
                Template::HANDLE => $template->{Template::HANDLE} . '_copy',
                Template::NAME => $template->{Template::NAME} . ' (copy)',
            ])
            ->save();

        $this->syncSections($replicated, $template->sections()->get()->toArray());
        $this->syncSets($replicated, $template->sets()->get()->toArray());
    }

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

    /**
     * @param Template $template
     * @param array $blocks
     *
     * @return void
     */
    protected function syncSets(Template $template, array $blocks): void
    {
        $template->sets()->sync(collect($blocks)->pluck(Block::ID));
    }

    #endregion
}
