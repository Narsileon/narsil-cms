<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface TimeInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * @param string $max The latest time.
     *
     * @return static Returns the current object instance.
     */
    public function max(string $max): static;

    /**
     * @param string $min The earliest time.
     *
     * @return static Returns the current object instance.
     */
    public function min(string $min): static;

    /**
     * @param boolean $required Must the input have a value?
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param string $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion

    #endregion
}
