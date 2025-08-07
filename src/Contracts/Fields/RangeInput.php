<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RangeInput extends Field
{
    #region FLUENT METHODS

    /**
     * @param float|integer $max The maximum number.
     *
     * @return static Returns the current object instance.
     */
    public function max(float|int $max): static;

    /**
     * @param float|integer $min The minimum number.
     *
     * @return static Returns the current object instance.
     */
    public function min(float|int $min): static;

    /**
     * @param float|integer $step The interval between two numbers.
     *
     * @return static Returns the current object instance.
     */
    public function step(float|int $step): static;

    /**
     * @param array<float|integer> $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion
}
