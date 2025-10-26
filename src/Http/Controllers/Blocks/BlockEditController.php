<?php

namespace Narsil\Http\Controllers\Blocks;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Contracts\Forms\BlockForm;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockEditController extends AbstractController
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
        $form = $this->getForm($block)
            ->setData($data);

        return $this->render(
            component: 'narsil/cms::resources/form',
            props: $form->jsonSerialize(),
        );
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
        $data = $block->toArrayWithTranslations();

        return $data;
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
        $form = app()
            ->make(BlockForm::class)
            ->setAction(route('blocks.update', $block->{Block::ID}))
            ->setId($block->{Block::ID})
            ->setMethod(MethodEnum::PATCH)
            ->setSubmitLabel(trans('narsil::ui.update'));

        return $form;
    }

    #endregion
}
