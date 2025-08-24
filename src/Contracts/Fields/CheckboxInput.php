<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface CheckboxInput extends Contract
{
    #region FLUENT METHODS

    /**
     * @param boolean $inline.
     *
     * @return static Returns the current object instance.
     */
    public function inline(bool $inline): static;

    /**
     * @param array $options.
     *
     * @return static Returns the current object instance.
     */
    public function options(array $options): static;

    /**
     * @param boolean $required Must the input have a value?
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param boolean $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(bool $value): static;

    #endregion
}
