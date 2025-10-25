<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface EmailField extends Contract
{
    #region PUBLIC METHODS

    #region • SETTERS

    /**
     * Set the autocomplete attribute.
     *
     * @param AutoCompleteEnum $autoComplete
     *
     * @return static
     */
    public function setAutoComplete(AutoCompleteEnum $autoComplete): static;

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function setDefaultvalue(string $value): static;

    /**
     * Set the icon attribute.
     *
     * @param string $icon
     *
     * @return static
     */
    public function setIcon(string $icon): static;

    /**
     * Set the multiple attribute.
     *
     * @param boolean $multiple
     *
     * @return static
     */
    public function setMultiple(bool $multiple): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function setPlaceholder(string $placeholder): static;

    /**
     * Set the required attribute.
     *
     * @param boolean $required
     *
     * @return static
     */
    public function setRequired(bool $required): static;

    #endregion

    #endregion
}
