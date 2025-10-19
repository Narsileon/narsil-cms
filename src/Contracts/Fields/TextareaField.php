<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface TextareaField extends Contract
{
    #region PUBLIC METHODS

    #region • SETTERS

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function setDefaultValue(string $value): static;

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
