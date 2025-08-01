<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TextInput extends Field
{
    #region PUBLIC METHODS

    /**
     * @param string $autoComplete
     *
     * @return static Returns the current object instance.
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * @param string $maxLength
     *
     * @return static Returns the current object instance.
     */
    public function maxLength(string $maxLength): static;

    /**
     * @param string $minLength
     *
     * @return static Returns the current object instance.
     */
    public function minLength(string $minLength): static;

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
     * @param string $type
     *
     * @return static Returns the current object instance.
     */
    public function type(string $type): static;

    /**
     * @param string $value
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
