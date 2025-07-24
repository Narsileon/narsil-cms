<?php

namespace Narsil\Contracts\Fields\Number;

#region USE

use Narsil\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface NumberFieldSettings extends FieldSettings
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
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
     * @param boolean $required
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param string $step
     *
     * @return static Returns the current object instance.
     */
    public function step(string $step): static;

    /**
     * @param float|int $value
     *
     * @return static Returns the current object instance.
     */
    public function value(float|int $value): static;

    #endregion
}
