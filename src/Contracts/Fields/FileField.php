<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface FileField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the accept attribute.
     *
     * @param string $accept
     *
     * @return static
     */
    public function accept(string $accept): static;

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultValue(string $value): static;

    /**
     * Set the icon attribute.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon(string $icon): static;

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
