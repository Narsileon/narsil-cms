<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface SelectInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * @param string $placeholder The text displayed when the input has no value.
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
     * @param array $options
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
     * @param string $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion

    #endregion
}
