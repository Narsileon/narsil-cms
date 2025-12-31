<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
 */
interface EntityField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultvalue(string $value): static;

    /**
     * Set the multiple attribute.
     *
     * @param boolean $multiple
     *
     * @return static
     */
    public function multiple(bool $multiple): static;

    #endregion
}
