<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
