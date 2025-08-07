<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Response;
use Narsil\Contracts\FormRequests\FieldFormRequest;
use Narsil\Contracts\Forms\FieldForm;
use Narsil\Contracts\Tables\FieldTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldBlock;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param FieldForm $form
     * @param FieldFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(FieldForm $form, FieldFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var FieldForm
     */
    protected readonly FieldForm $form;
    /**
     * @var FieldFormRequest
     */
    protected readonly FieldFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $query = Field::query();

        $dataTable = new DataTableCollection($query, app(FieldTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.fields'),
            description: trans('narsil-cms::ui.fields'),
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

        $field = Field::create($attributes);

        if ($blocks = Arr::get($attributes, Field::RELATION_BLOCKS))
        {
            $this->syncBlocks($field, $blocks);
        }

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            $this->syncOptions($field, $options);
        }

        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil-cms::toasts.success.fields.created'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Field $field): JsonResponse|Response
    {
        $this->form
            ->method(MethodEnum::PATCH)
            ->submit(trans('narsil-cms::ui.update'))
            ->url(route('fields.update', $field->{Field::ID}));

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $field,
            ]),
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
        $attributes = $this->getAttributes($this->formRequest->rules());

        $field->update($attributes);

        if ($blocks = Arr::get($attributes, Field::RELATION_BLOCKS))
        {
            $this->syncBlocks($field, $blocks);
        }

        if ($options = Arr::get($attributes, Field::RELATION_OPTIONS))
        {
            $this->syncOptions($field, $options);
        }


        return $this
            ->redirect(route('fields.index'), $field)
            ->with('success', trans('narsil-cms::toasts.success.fields.updated'));
    }

    /**
     * @param Request $request
     * @param Field $field
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Field $field): RedirectResponse
    {
        $field->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', trans('narsil-cms::toasts.success.fields.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $ids = $request->validated(DestroyManyRequest::IDS);

        Field::whereIn(Field::ID, $ids)->delete();

        return $this
            ->redirect(route('fields.index'))
            ->with('success', trans('narsil-cms::toasts.success.fields.deleted_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Field $field
     * @param array $blocks
     *
     * @return void
     */
    protected function syncBlocks(Field $field, array $blocks): void
    {
        $field->blocks()->sync(collect($blocks)->pluck(FieldBlock::ID));
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
