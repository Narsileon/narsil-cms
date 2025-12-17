<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
     * @param array<string> $modules
     *
     * @return static
     */
    public function modules(array $modules): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function placeholder(string $placeholder): static;

    #endregion
}
