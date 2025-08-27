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
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Requests\DestroyManyRequest;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class BlockController extends AbstractController
{
    #region CONSTRUCTOR

    /**
     * @param BlockForm $form
     * @param BlockFormRequest $formRequest
     *
     * @return void
     */
    public function __construct(BlockForm $form, BlockFormRequest $formRequest)
    {
        $this->form = $form;
        $this->formRequest = $formRequest;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var BlockForm
     */
    protected readonly BlockForm $form;
    /**
     * @var BlockFormRequest
     */
    protected readonly BlockFormRequest $formRequest;

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Block::class);

        $query = Block::query()
            ->with([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ])
            ->withCount([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ]);

        $dataTable = new DataTableCollection($query, Block::TABLE);

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil::tables.blocks'),
            description: trans('narsil::tables.blocks'),
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
        $this->authorize(PermissionEnum::CREATE, Block::class);

        $this->form->method = MethodEnum::POST;
        $this->form->url = route('blocks.store');

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
        $this->authorize(PermissionEnum::CREATE, Block::class);

        $data = $request->all();
        $rules = $this->formRequest->rules();

        $attributes = Validator::make($data, $rules)
            ->validated();

        $block = Block::create($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            $this->syncElements($block, $elements);
        }

        if ($sets = Arr::get($attributes, Block::RELATION_SETS))
        {
            $this->syncSets($block, $sets);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', trans('narsil::toasts.success.blocks.created'));
    }

    /**
     * @param Request $request
     * @param Block $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Block $block): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $block);

        $block->loadMissing([
            Block::RELATION_ELEMENTS . '.' . BlockElement::RELATION_ELEMENT,
        ]);

        $this->form->method = MethodEnum::PATCH;
        $this->form->url = route('blocks.update', [
            Str::singular(Block::TABLE) => $block->{Block::ID}
        ]);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: array_merge($this->form->jsonSerialize(), [
                'data' => $block,
            ]),
        );
    }

    /**
     * @param Request $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Block $block): RedirectResponse
    {
        $this->authorize(PermissionEnum::UPDATE, $block);

        $data = $request->all();
        $rules = $this->formRequest->rules($block);

        $attributes = Validator::make($data, $rules)
            ->validated();

        $block->update($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            $this->syncElements($block, $elements);
        }

        if ($sets = Arr::get($attributes, Block::RELATION_SETS))
        {
            $this->syncSets($block, $sets);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', trans("narsil::toasts.success.blocks.updated"));
    }

    /**
     * @param Request $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Block $block): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE, $block);

        $block->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', trans('narsil::toasts.success.blocks.deleted'));
    }

    /**
     * @param DestroyManyRequest $request
     *
     * @return RedirectResponse
     */
    public function destroyMany(DestroyManyRequest $request): RedirectResponse
    {
        $this->authorize(PermissionEnum::DELETE_ANY, Block::class);

        $ids = $request->validated(DestroyManyRequest::IDS);

        Block::whereIn(Block::ID, $ids)->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', trans('narsil::toasts.success.blocks.deleted_many'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Block $block
     * @param array $elements
     *
     * @return void
     */
    protected function syncElements(Block $block, array $elements): void
    {
        $block->blocks()->detach();
        $block->fields()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, BlockElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                BlockElement::HANDLE => Arr::get($element, BlockElement::HANDLE),
                BlockElement::NAME => Arr::get($element, BlockElement::NAME),
                BlockElement::POSITION => $position,
                BlockElement::WIDTH => Arr::get($element, BlockElement::WIDTH),
            ];

            match ($table)
            {
                Block::TABLE => $block->blocks()->attach($id, $attributes),
                Field::TABLE => $block->fields()->attach($id, $attributes),
                default => null,
            };
        }
    }

    /**
     * @param Block $block
     * @param array $blocks
     *
     * @return void
     */
    protected function syncSets(Block $block, array $blocks): void
    {
        $block->sets()->sync(collect($blocks)->pluck(Block::ID));
    }

    #endregion
}
