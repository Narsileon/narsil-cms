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
interface EmailField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the auto complete attribute.
     *
     * @param string $autoComplete
     *
     * @return static
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultvalue(string $value): static;

    /**
     * Set the icon attribute.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon(string $icon): static;

    /**
     * Set the multiple attribute.
     *
     * @param boolean $multiple
     *
     * @return static
     */
    public function multiple(bool $multiple): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function placeholder(string $placeholder): static;

    #endregion
}
