<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface FileInput extends Contract
{
    #region FLUENT METHODS

    /**
     * @param string $accept The file types.
     *
     * @return static Returns the current object instance.
     */
    public function accept(string $accept): static;

    /**
     * @param string $icon The name of the icon.
     *
     * @return static Returns the current object instance.
     */
    public function icon(string $icon): static;

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
}
