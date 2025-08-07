<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SwitchInput extends Field
{
    #region FLUENT METHODS

    /**
     * @param boolean $checked The default value.
     *
     * @return static Returns the current object instance.
     */
    public function checked(bool $checked): static;

    #endregion
}
