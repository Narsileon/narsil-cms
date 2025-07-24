<?php

namespace Narsil\Contracts\Fields\Text;

#region USE

use Narsil\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface EmailFieldSettings extends FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param string $autoComplete
     *
     * @return static Returns the current object instance.
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * @param boolean $multiple
     *
     * @return static Returns the current object instance.
     */
    public function multiple(bool $multiple): static;

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
     * @param string $value
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
