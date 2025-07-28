<?php

namespace Narsil\Contracts\FormElements;

#region USE

use Narsil\Contracts\FormElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface CheckboxInput extends FormElement
{
    #region PUBLIC METHODS

    /**
     * @param boolean $checked
     *
     * @return static Returns the current object instance.
     */
    public function checked(bool $checked): static;

    #endregion
}
