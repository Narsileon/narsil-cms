<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;
use Narsil\Models\Elements\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface ArrayField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function defaultValue(array $value): static;

    /**
     * Set the block attribute.
     *
     * @param Block $block
     *
     * @return static
     */
    public function block(Block $block): static;

    /**
     * Set the label key.
     *
     * @param string $labelKey
     *
     * @return static
     */
    public function labelKey(string $labelKey): static;

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
