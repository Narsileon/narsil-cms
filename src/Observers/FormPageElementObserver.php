<?php

namespace Narsil\Observers;

#region USE

use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FormPageElement;
use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormPageElementObserver
{
    #region PUBLIC METHODS

    /**
     * @param FormPageElement $model
     *
     * @return void
     */
    public function saving(FormPageElement $model): void
    {
        match ($model->{FormPageElement::ELEMENT_TYPE})
        {
            Fieldset::class => $model->{FormPageElement::FIELDSET_ID} = $model->{FormPageElement::ELEMENT_ID},
            Input::class => $model->{FormPageElement::INPUT_ID} = $model->{FormPageElement::ELEMENT_ID},
            default => null,
        };
    }

    #endregion
}
