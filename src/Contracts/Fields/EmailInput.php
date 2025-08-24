<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Fields\TextInput;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface EmailInput extends TextInput
{
    #region FLUENT METHODS

    /**
     * @param boolean $multiple Does the input accept comma-separated value?
     *
     * @return static Returns the current object instance.
     */
    public function multiple(bool $multiple): static;

    #endregion
}
