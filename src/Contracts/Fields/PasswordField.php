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
interface PasswordField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the auto complete attribute.
     *
     * @param string $autoComplete
     *
     * @return static
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultvalue(string $value): static;

    /**
     * Set the icon attribute.
     *
     * @param string $icon.
     *
     * @return static
     */
    public function icon(string $icon): static;

    /**
     * Set the max length attribute.
     *
     * @param string $maxLength e.g. "255"
     *
     * @return static
     */
    public function maxLength(string $maxLength): static;

    /**
     * Set the min length attribute.
     *
     * @param string $minLength e.g. "8"
     *
     * @return static
     */
    public function minLength(string $minLength): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function placeholder(string $placeholder): static;

    /**
     * Set the required attribute.
     *
     * @param boolean $required
     *
     * @return static
     */
    public function required(bool $required): static;

    #endregion
}
