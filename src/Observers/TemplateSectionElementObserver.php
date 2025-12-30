<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSectionElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param TemplateSectionElement $model
     *
     * @return void
     */
    public function saving(TemplateSectionElement $model): void
    {
        match ($model->{TemplateSectionElement::ELEMENT_TYPE})
        {
            Block::class => $model->{TemplateSectionElement::BLOCK_ID} = $model->{TemplateSectionElement::ELEMENT_ID},
            Field::class => $model->{TemplateSectionElement::FIELD_ID} = $model->{TemplateSectionElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
