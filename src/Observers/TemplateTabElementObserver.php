<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param TemplateTabElement $model
     *
     * @return void
     */
    public function saving(TemplateTabElement $model): void
    {
        match ($model->{TemplateTabElement::ELEMENT_TYPE})
        {
            Block::TABLE => $model->{TemplateTabElement::BLOCK_ID} = $model->{TemplateTabElement::ELEMENT_ID},
            Field::TABLE => $model->{TemplateTabElement::FIELD_ID} = $model->{TemplateTabElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
