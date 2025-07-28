<?php

namespace Narsil\Contracts\FormElements;

#region USE

use Narsil\Contracts\FormElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RichTextInput extends FormElement
{
    #region PUBLIC METHODS

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
