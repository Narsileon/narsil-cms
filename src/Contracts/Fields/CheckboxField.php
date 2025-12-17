<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface CheckboxField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param array|boolean $value
     *
     * @return static
     */
    public function defaultValue(array|bool $value): static;

    #endregion
}
