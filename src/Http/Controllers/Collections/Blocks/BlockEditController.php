<?php

namespace Narsil\Cms\Http\Controllers\Collections\Blocks;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Casts\HumanDatetimeCast;
use Narsil\Cms\Contracts\Forms\BlockForm;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Services\ModelService;

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
            Block::RELATION_ELEMENTS . '.' . BlockElement::RELATION_BASE,
        ]);

        $data = $this->getData($block);
        $form = $this->getForm($block);

        return $this->render('narsil/cms::resources/form', [
            'data' => $data,
            'form' => $form,
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
        return ModelService::getModelLabel(Block::TABLE);
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
        $form = app(BlockForm::class, ['model' => $block])
            ->action(route('blocks.update', $block->{Block::ID}))
            ->id($block->{Block::ID})
            ->method(RequestMethodEnum::PATCH->value)
            ->submitLabel(trans('narsil-cms::ui.update'));

        return $form;
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getModelLabel(Block::TABLE);
    }

    #endregion
}
