<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Contracts\Tables\BlockTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
        $query = Block::query()
            ->with([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ])
            ->withCount([
                Block::RELATION_BLOCKS,
                Block::RELATION_FIELDS,
            ]);

        $dataTable = new DataTableCollection($query, app(BlockTable::class));

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: trans('narsil-cms::ui.blocks'),
            description: trans('narsil-cms::ui.blocks'),
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
            url: route('blocks.store'),
            method: MethodEnum::POST,
            submit: trans('narsil-cms::ui.create'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.block'),
            description: trans('narsil-cms::ui.block'),
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

        $block = Block::create($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            $this->syncBlockElements($block, $elements);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', trans('narsil-cms::toasts.success.blocks.created'));
    }

    /**
     * @param Request $request
     * @param Block $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Block $block): JsonResponse|Response
    {
        $block->loadMissing([
            Block::RELATION_ELEMENTS . '.' . BlockElement::RELATION_ELEMENT,
        ]);

        $form = $this->form->get(
            url: route('blocks.update', $block->{Block::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.block'),
            description: trans('narsil-cms::ui.block'),
            props: [
                'data' => $block,
                'form' => $form,
            ]
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
        $attributes = $this->getAttributes($this->formRequest->rules());

        $block->update($attributes);

        if ($elements = Arr::get($attributes, Block::RELATION_ELEMENTS))
        {
            $this->syncBlockElements($block, $elements);
        }

        return $this
            ->redirect(route('blocks.index'), $block)
            ->with('success', trans("narsil-cms::toasts.success.blocks.updated"));
    }

    /**
     * @param Request $request
     * @param Block $block
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Block $block): RedirectResponse
    {
        $block->delete();

        return $this
            ->redirect(route('blocks.index'))
            ->with('success', trans('narsil-cms::toasts.success.blocks.deleted'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Block $block
     * @param array $elements
     *
     * @return void
     */
    protected function syncBlockElements(Block $block, array $elements): void
    {
        $block->blocks()->detach();
        $block->fields()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, BlockElement::IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            match ($table)
            {
                Block::TABLE => $block->blocks()->attach($id, [
                    BlockElement::POSITION => $position,
                ]),
                Field::TABLE => $block->fields()->attach($id, [
                    BlockElement::POSITION => $position,
                ]),
                default => null,
            };
        }
    }

    #endregion
}
