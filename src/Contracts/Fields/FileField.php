<?php

namespace Narsil\Cms\Contracts\Fields;

#region USE

use Narsil\Cms\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
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

    #endregion
}
