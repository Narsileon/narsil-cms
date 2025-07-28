<?php

namespace Narsil\Contracts\FormElements;

#region USE

use Narsil\Contracts\FormElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SelectInput extends FormElement
{
    #region PUBLIC METHODS

    /**
     * @param string $placeholder
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
     * @param boolean $required
     *
     * @return static Returns the current object instance.
     */
    public function required(bool $required): static;

    /**
     * @param boolean $search
     *
     * @return static Returns the current object instance.
     */
    public function search(bool $search): static;

    /**
     * @param string $value
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion
}
