<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\FormRequests\BlockFormRequest;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Contracts\Tables\BlockTable;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Http\Controllers\AbstractResourceController;
use Narsil\Http\Resources\DataTableCollection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockController extends AbstractResourceController
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

        $Block = Block::create($attributes);

        return $this->redirectOnStored(Block::TABLE, $Block);
    }

    /**
     * @param Request $request
     * @param Block $field
     *
     * @return JsonResponse|Response
     */
    public function edit(Request $request, Block $Block): JsonResponse|Response
    {
        $Block->loadMissing([
            Block::RELATION_ELEMENTS . '.' . BlockElement::RELATION_ELEMENT,
        ]);

        $form = $this->form->get(
            url: route('blocks.update', $Block->{Block::ID}),
            method: MethodEnum::PATCH,
            submit: trans('narsil-cms::ui.update'),
        );

        return $this->render(
            component: 'narsil/cms::resources/form',
            title: trans('narsil-cms::ui.block'),
            description: trans('narsil-cms::ui.block'),
            props: [
                'data' => $Block,
                'form' => $form,
            ]
        );
    }

    /**
     * @param Request $request
     * @param Block $Block
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Block $Block): RedirectResponse
    {
        $attributes = $this->getAttributes($this->formRequest->rules());

        $Block->update($attributes);

        return $this->redirectOnUpdated(Block::TABLE, $Block);
    }

    /**
     * @param Request $request
     * @param Block $Block
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, Block $Block): RedirectResponse
    {
        $Block->delete();

        return $this->redirectOnDestroyed(Block::TABLE);
    }

    #endregion
}
