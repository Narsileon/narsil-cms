<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Definitions;

#region USE

use Narsil\Base\Resources\AbstractModelDefinition;
use Narsil\Cms\Contracts\Actions\Blocks\ReplicateBlock;
use Narsil\Cms\Contracts\Forms\BlockForm;
use Narsil\Cms\Contracts\Requests\BlockFormRequest;
use Narsil\Cms\Models\Collections\Block;

#endregion

final class BlockDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    public function editWith(): array
    {
        return [Block::RELATION_ELEMENTS];
    }

    public function form(): ?string
    {
        return BlockForm::class;
    }

    public function indexWith(): array
    {
        return [Block::RELATION_ELEMENTS];
    }

    public function model(): string
    {
        return Block::class;
    }

    public function replicateAction(): ?string
    {
        return ReplicateBlock::class;
    }

    public function request(): ?string
    {
        return BlockFormRequest::class;
    }

    public function route(): string
    {
        return 'blocks';
    }

    #endregion
}
