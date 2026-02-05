<?php

namespace Narsil\Cms\Contracts\Fields;

#region USE

use Narsil\Cms\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
 */
interface SwitchField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param boolean $value
     *
     * @return static
     */
    public function defaultValue(bool $value): static;

    #endregion
}
