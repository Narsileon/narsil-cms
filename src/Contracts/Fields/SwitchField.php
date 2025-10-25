<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SwitchField extends Contract
{
    #region PUBLIC METHODS

    #region • SETTERS

    /**
     * Set the default value.
     *
     * @param boolean $value
     *
     * @return static
     */
    public function setDefaultValue(bool $value): static;

    #endregion

    #endregion
}
