<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SelectField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultValue(string $value): static;

    /**
     * Set the display value attribute.
     *
     * @param boolean $displayValue
     *
     * @return static
     */
    public function displayValue(bool $displayValue): static;

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

    /**
     * Set the reload attribute.
     *
     * @param string $reload
     *
     * @return static
     */
    public function reload(string $reload): static;

    #endregion
}
