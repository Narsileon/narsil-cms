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
class BlockObserver
{
    #region PUBLIC METHODS

    /**
     * @param Block $model
     *
     * @return void
     */
    public function retrieved(Block $model): void
    {
        foreach ($model->{Block::RELATION_ELEMENTS} as $element)
        {
            if ($element->{BlockElement::BASE_TYPE} === Field::TABLE)
            {
                app($element->{BlockElement::RELATION_BASE}->{Field::TYPE})::bootTranslations();
            }
        }
    }

    #endregion
}
