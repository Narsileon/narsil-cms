<?php

namespace App\Contracts\Fields\Number;

#region USE

use App\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RangeFieldSettings extends FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param string $max
     *
     * @return static Returns the current object instance.
     */
    public function max(string $max): static;

    /**
     * @param string $min
     *
     * @return static Returns the current object instance.
     */
    public function min(string $min): static;

    /**
     * @param string $step
     *
     * @return static Returns the current object instance.
     */
    public function step(string $step): static;

    /**
     * @param array<float|int> $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion
}
