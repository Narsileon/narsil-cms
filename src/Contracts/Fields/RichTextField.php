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
interface RichTextField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultValue(string $value): static;

    /**
     * Set the modules attribute.
     *
     * @param string[] $modules
     *
     * @return static
     */
    public function modules(array $modules): static;

    #endregion
}
