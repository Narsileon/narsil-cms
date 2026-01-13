<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FormStepElement;
use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormStepElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param FormStepElement $model
     *
     * @return void
     */
    public function saving(FormStepElement $model): void
    {
        match ($model->{FormStepElement::BASE_TYPE})
        {
            Fieldset::TABLE => $model->{FormStepElement::FIELDSET_ID} = $model->{FormStepElement::BASE_ID},
            Input::TABLE => $model->{FormStepElement::INPUT_ID} = $model->{FormStepElement::BASE_ID},
            default => null,
        };
    }

    #endregion
}
