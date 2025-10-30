<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TreeField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function defaultValue(array $value): static;

    #endregion
}
