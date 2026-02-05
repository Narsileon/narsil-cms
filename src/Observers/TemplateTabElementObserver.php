<?php

namespace Narsil\Cms\Observers;

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTabElement;

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
        match ($model->{TemplateTabElement::BASE_TYPE})
        {
            Block::TABLE => $model->{TemplateTabElement::BLOCK_ID} = $model->{TemplateTabElement::BASE_ID},
            Field::TABLE => $model->{TemplateTabElement::FIELD_ID} = $model->{TemplateTabElement::BASE_ID},
            default => null,
        };
    }

    #endregion
}
