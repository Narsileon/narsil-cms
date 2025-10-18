<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface DateField extends Contract
{
    #region PUBLIC METHODS

    #region • SETTERS

    /**
     * Set the default value.
     *
     * @param string $value e.g. "2025-01-01"
     *
     * @return static
     */
    public function setDefaultValue(string $value): static;

    /**
     * Set the max attribute.
     *
     * @param string $max e.g. "2000-01-01"
     *
     * @return static
     */
    public function setMax(string $max): static;

    /**
     * Set the min attribute.
     *
     * @param string $min e.g. "2099-12-31"
     *
     * @return static
     */
    public function setMin(string $min): static;

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
