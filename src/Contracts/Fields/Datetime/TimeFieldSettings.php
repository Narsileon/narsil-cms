<?php

namespace Narsil\Contracts\Fields\Datetime;

#region USE

use Narsil\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TimeFieldSettings extends FieldSettings
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
     * @param boolean $required
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param string $value
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
