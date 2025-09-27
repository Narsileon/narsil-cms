<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface RangeField extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * Set the default value.
     *
     * @param array<float|integer> $value
     *
     * @return static
     */
    public function setDefaultValue(array $value): static;

    /**
     * Set the max attribute.
     *
     * @param float|integer $max e.g. "100".
     *
     * @return static
     */
    public function setMax(float|int $max): static;

    /**
     * Set the min attribute.
     *
     * @param float|integer $min e.g. "0".
     *
     * @return static
     */
    public function setMin(float|int $min): static;

    /**
     * Set the step attribute.
     *
     * @param float|integer $step e.g. "1".
     *
     * @return static
     */
    public function setStep(float|int $step): static;

    #endregion

    #endregion
}
