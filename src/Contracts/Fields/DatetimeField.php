<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface DatetimeField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param string $value e.g. "2025-01-01T12:00"
     *
     * @return static
     */
    public function defaultValue(string $value): static;

    /**
     * Set the max attribute.
     *
     * @param string $max e.g. "2099-12-31T23:59"
     *
     * @return static
     */
    public function max(string $max): static;

    /**
     * Set the min attribute.
     *
     * @param string $min e.g. "2000-01-01T00:00"
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
