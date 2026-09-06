<?php

declare(strict_types=1);

namespace Narsil\Cms\Definitions;

#region USE

use Narsil\Base\Definitions\AbstractModelDefinition;
use Narsil\Base\Enums\ModelHookEventEnum;
use Narsil\Base\Http\Data\ModelHookContext;
use Illuminate\Support\Arr;
use Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements;
use Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock;
use Narsil\Cms\Contracts\Forms\BlockForm;
use Narsil\Cms\Contracts\Requests\BlockFormRequest;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Implementations\Tables\BlockTable;

#endregion

final class BlockDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function editWith(): array
    {
        return [
            Block::RELATION_BLOCKS,
            Block::RELATION_ELEMENTS,
            Block::RELATION_FIELDS
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return BlockForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function hooks(): array
    {
        $hook = function (ModelHookContext $context): void
        {
            if ($context->model instanceof Block)
            {
                app(SyncBlockElements::class)->run($context->model, Arr::get($context->attributes, Block::RELATION_ELEMENTS, []));
            }
        };

        return [
            ModelHookEventEnum::AFTER_STORE->value => [
                [
                    'hook' => $hook,
                    'priority' => 0
                ],
            ],
            ModelHookEventEnum::AFTER_UPDATE->value => [
                [
                    'hook' => $hook,
                    'priority' => 0
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWith(): array
    {
        return [
            Block::RELATION_BLOCKS,
            Block::RELATION_ELEMENTS,
            Block::RELATION_FIELDS
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function indexWithCount(): array
    {
        return [
            Block::RELATION_BLOCKS,
            Block::RELATION_FIELDS
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Block::class;
    }

    /**
     * {@inheritDoc}
     */
    public function morph(): ?string
    {
        return Block::TABLE;
    }

    /**
     * {@inheritDoc}
     */
    public function replicateAction(): ?string
    {
        return ReplicateBlock::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return BlockFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return 'blocks';
    }

    /**
     * {@inheritDoc}
     */
    public function table(): ?string
    {
        return BlockTable::class;
    }

    #endregion
}
