<?php

namespace Narsil\Contracts\FormElements;

#region USE

use Narsil\Contracts\FormElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RelationsInput extends FormElement
{
    #region PUBLIC METHODS

    /**
     * @param string $create
     *
     * @return static Returns the current object instance.
     */
    public function create(string $create): static;

    /**
     * @param int $columns
     *
     * @return static Returns the current object instance.
     */
    public function columns(int $columns): static;

    /**
     * @param array $options
     *
     * @return static Returns the current object instance.
     */
    public function options(array $options): static;

    /**
     * @param array $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion
}
