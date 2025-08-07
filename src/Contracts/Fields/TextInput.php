<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TextInput extends Contract
{
    #region FLUENT METHODS

    /**
     * @param string $autoComplete
     *
     * @return static Returns the current object instance.
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * @param string $maxLength The maximum length of the string.
     *
     * @return static Returns the current object instance.
     */
    public function maxLength(string $maxLength): static;

    /**
     * @param string $minLength The minimum length of the string.
     *
     * @return static Returns the current object instance.
     */
    public function minLength(string $minLength): static;

    /**
     * @param string $placeholder The text displayed when the input has no value.
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
     * @param boolean $required Must the input have a value?
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param string $type The type of the input.
     *
     * @return static Returns the current object instance.
     */
    public function type(string $type): static;

    /**
     * @param string $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
