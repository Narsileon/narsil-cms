<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Inertia\Response;
use Narsil\Contracts\FormRequests\FieldFormRequest;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Requests\DuplicateManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FieldController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Field::class);

        $query = Field::query();

        $collection = new DataTableCollection($query, Field::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.fields'),
            description: trans('narsil::tables.fields'),
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
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $form = app(FieldForm::class);

        $form->action = route('fields.store');
        $form->method = MethodEnum::POST;
        $form->submitLabel = trans('narsil::ui.save');

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
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $data = $request->all();

        $rules = app(FieldFormRequest::class)->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $field = Field::create($attributes);

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            $this->syncOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil::toasts.success.fields.created'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Field $field): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $field);

        if (!$request->has(Field::TYPE))
        {
            $request->merge([
                Field::TYPE => $field->{Field::TYPE},
            ]);
        }

        $form = app(FieldForm::class);

        $form->action = route('fields.update', $field->{Field::ID});
        $form->data = $field;
        $form->id = $field->{Field::ID};
        $form->method = MethodEnum::PATCH;
        $form->submitLabel = trans('narsil::ui.update');

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $field);

        $data = $request->all();

        $rules = app(FieldFormRequest::class)->rules($field);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $field->update($attributes);

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            $this->syncOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil::toasts.success.fields.updated'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $field);

        $field->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', trans('narsil::toasts.success.fields.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Field::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Field::whereIn(Field::ID, $ids)->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', trans('narsil::toasts.success.fields.deleted_many'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function replicate(Request $request, Field $field): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $this->replicateField($field);

        return back()
            ->with('success', trans('narsil::toasts.success.fields.replicated'));
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function replicateMany(DuplicateManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::CREATE, Field::class);

        $ids = $request->validated(DuplicateManyRequest::IDS);

        $fields = Field::query()
            ->findMany($ids);

        foreach ($fields as $field)
        {
            $this->replicateField($field);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.fields.replicated_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Field $field
     *
     * @return void
     */
    protected function replicateField(Field $field): void
    {
        $replicated = $field->replicate();

        $replicated
            ->fill([
                Field::HANDLE => $field->{Field::HANDLE} . '_copy',
                Field::NAME => $field->{Field::NAME} . ' (copy)',
            ])
            ->save();

        $this->syncOptions($replicated, $field->options()->get()->toArray());
    }

    /**
     * @param Field $field
     * @param array $options
     *
     * @return void
     */
    protected function syncOptions(Field $field, array $options): void
    {
        $ids = [];

        foreach ($options as $key => $option)
        {
            $fieldOption = FieldOption::updateOrCreate([
                FieldOption::FIELD_ID => $field->{Field::ID},
                FieldOption::VALUE => $option[FieldOption::VALUE],
            ], [
                FieldOption::POSITION => $key,
                FieldOption::LABEL => $option[FieldOption::LABEL],
            ]);

            $ids[] = $fieldOption->{FieldOption::ID};
        }

        $field->options()
            ->whereNotIn(FieldOption::ID, $ids)
            ->delete();
    }

    #endregion
}
