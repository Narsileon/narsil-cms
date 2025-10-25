<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface CheckboxField extends Contract
{
    #region PUBLIC METHODS

    #region • SETTERS

    /**
     * Set the default value.
     *
     * @param array|boolean $value
     *
     * @return static
     */
    public function setDefaultValue(array|bool $value): static;

    /**
     * Set the options attribute.
     *
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options): static;

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
