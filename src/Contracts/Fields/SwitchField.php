<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
