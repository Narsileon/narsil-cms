<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface RichTextInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * @param array<string> $modules The list of modules available in the toolbar.
     *
     * @return static Returns the current object instance.
     */
    public function modules(array $modules): static;

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
     * @param string $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(string $value): static;

    #endregion

    #endregion
}
