<?php

namespace Narsil\Contracts\Fields\Select;

#region USE

use Narsil\Contracts\Fields\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SwitchField extends AbstractField
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
