<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param FieldsetElement $model
     *
     * @return void
     */
    public function saving(FieldsetElement $model): void
    {
        match ($model->{FieldsetElement::ELEMENT_TYPE})
        {
            Fieldset::class => $model->{FieldsetElement::FIELDSET_ID} = $model->{FieldsetElement::ELEMENT_ID},
            Input::class => $model->{FieldsetElement::INPUT_ID} = $model->{FieldsetElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
