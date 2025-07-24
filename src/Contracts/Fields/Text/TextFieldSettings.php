<?php

namespace Narsil\Contracts\Fields\Text;

#region USE

use Narsil\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TextFieldSettings extends FieldSettings
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
     * @param string $value
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
