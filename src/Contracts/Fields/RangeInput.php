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
    #region PUBLIC METHODS

    /**
     * @param float|int $max
     *
     * @return static Returns the current object instance.
     */
    public function max(float|int $max): static;

    /**
     * @param float|int $min
     *
     * @return static Returns the current object instance.
     */
    public function min(float|int $min): static;

    /**
     * @param float|int $step
     *
     * @return static Returns the current object instance.
     */
    public function step(float|int $step): static;

    /**
     * @param array<float|int> $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion
}
