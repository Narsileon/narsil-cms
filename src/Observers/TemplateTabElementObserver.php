<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTabElement;

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
            Block::class => $model->{TemplateTabElement::BLOCK_ID} = $model->{TemplateTabElement::ELEMENT_ID},
            Field::class => $model->{TemplateTabElement::FIELD_ID} = $model->{TemplateTabElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
