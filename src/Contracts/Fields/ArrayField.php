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

    #region • SETTERS

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function setDefaultValue(array $value): static;

    /**
     * Set the block attribute.
     *
     * @param Block $block
     *
     * @return static
     */
    public function setBlock(Block $block): static;

    /**
     * Set the label key.
     *
     * @param string $labelKey
     *
     * @return static
     */
    public function setLabelKey(string $labelKey): static;

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
