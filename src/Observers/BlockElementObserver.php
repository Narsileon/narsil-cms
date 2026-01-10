<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;

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
        match ($model->{BlockElement::ELEMENT_TYPE})
        {
            Block::TABLE => $model->{BlockElement::BLOCK_ID} = $model->{BlockElement::ELEMENT_ID},
            Field::TABLE => $model->{BlockElement::FIELD_ID} = $model->{BlockElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
