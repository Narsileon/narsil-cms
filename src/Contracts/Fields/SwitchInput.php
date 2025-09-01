<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface SwitchInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * @param boolean $checked The default value.
     *
     * @return static Returns the current object instance.
     */
    public function checked(bool $checked): static;

    #endregion

    #endregion
}
