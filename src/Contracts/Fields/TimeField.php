<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TimeField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param string $value e.g. "12:00"
     *
     * @return static
     */
    public function defaultValue(string $value): static;

    /**
     * Set the max attribute.
     *
     * @param string $max e.g. "23:59"
     *
     * @return static
     */
    public function max(string $max): static;

    /**
     * Set the min attribute.
     *
     * @param string $min e.g. "00:00"
     *
     * @return static
     */
    public function min(string $min): static;

    /**
     * Set the required attribute.
     *
     * @param boolean $required
     *
     * @return static
     */
    public function required(bool $required): static;

    #endregion
}
