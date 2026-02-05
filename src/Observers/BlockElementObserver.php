<?php

namespace Narsil\Cms\Observers;

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param BlockElement $model
     *
     * @return void
     */
    public function saving(BlockElement $model): void
    {
        match ($model->{BlockElement::BASE_TYPE})
        {
            Block::TABLE => $model->{BlockElement::BLOCK_ID} = $model->{BlockElement::BASE_ID},
            Field::TABLE => $model->{BlockElement::FIELD_ID} = $model->{BlockElement::BASE_ID},
            default => null,
        };
    }

    #endregion
}
