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
        match ($model->{FieldsetElement::BASE_TYPE})
        {
            Fieldset::TABLE => $model->{FieldsetElement::FIELDSET_ID} = $model->{FieldsetElement::BASE_ID},
            Input::TABLE => $model->{FieldsetElement::INPUT_ID} = $model->{FieldsetElement::BASE_ID},
            default => null,
        };
    }

    #endregion
}
