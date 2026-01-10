<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FormTabElement;
use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormTabElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param FormTabElement $model
     *
     * @return void
     */
    public function saving(FormTabElement $model): void
    {
        match ($model->{FormTabElement::BASE_TYPE})
        {
            Fieldset::TABLE => $model->{FormTabElement::FIELDSET_ID} = $model->{FormTabElement::BASE_ID},
            Input::TABLE => $model->{FormTabElement::INPUT_ID} = $model->{FormTabElement::BASE_ID},
            default => null,
        };
    }

    #endregion
}
