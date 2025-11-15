<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Casts\HumanDatetimeCast;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockEditController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param Block $field
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, Block $block): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::UPDATE, $block);

        $block->loadMissing([
            Block::RELATION_ELEMENTS . '.' . BlockElement::RELATION_ELEMENT,
        ]);

        $data = $this->getData($block);
        $form = $this->getForm($block);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form->jsonSerialize(),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated data.
     *
     * @param Block $block
     *
     * @return array<string,mixed>
     */
    protected function getData(Block $block): array
    {
        $block->loadMissingCreatorAndEditor();

        $block->mergeCasts([
            Block::CREATED_AT => HumanDatetimeCast::class,
            Block::UPDATED_AT => HumanDatetimeCast::class,
        ]);

        $data = $block->toArrayWithTranslations();

        return $data;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::models.' . Block::class);
    }

    /**
     * Get the associated form.
     *
     * @param Block $block
     *
     * @return BlockForm
     */
    protected function getForm(Block $block): BlockForm
    {
        $form = app(BlockForm::class)
            ->action(route('blocks.update', $block->{Block::ID}))
            ->id($block->{Block::ID})
            ->method(MethodEnum::PATCH->value)
            ->submitLabel(trans('narsil::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::models.' . Block::class);
    }

    #endregion
}
