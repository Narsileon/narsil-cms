<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RangeField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param array<float|integer> $value
     *
     * @return static
     */
    public function defaultValue(array $value): static;

    /**
     * Set the max attribute.
     *
     * @param float|integer $max e.g. "100".
     *
     * @return static
     */
    public function max(float|int $max): static;

    /**
     * Set the min attribute.
     *
     * @param float|integer $min e.g. "0".
     *
     * @return static
     */
    public function min(float|int $min): static;

    /**
     * Set the step attribute.
     *
     * @param float|integer $step e.g. "1".
     *
     * @return static
     */
    public function step(float|int $step): static;

    #endregion
}
