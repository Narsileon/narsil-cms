<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface NumberInput extends Contract
{
    #region FLUENT METHODS

    /**
     * @param string $max The maximum number.
     *
     * @return static Returns the current object instance.
     */
    public function max(string $max): static;

    /**
     * @param string $min The minimum number.
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
     * @param string $step The interval between two numbers.
     *
     * @return static Returns the current object instance.
     */
    public function step(string $step): static;

    /**
     * @param float|integer $value The default value
     *
     * @return static Returns the current object instance.
     */
    public function value(float|int $value): static;

    #endregion
}
