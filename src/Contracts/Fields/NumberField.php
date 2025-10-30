<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface NumberField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the default value.
     *
     * @param float|integer $value
     *
     * @return static
     */
    public function defaultValue(float|int $value): static;

    /**
     * Set the max attribute.
     *
     * @param string $max e.g. "100".
     *
     * @return static
     */
    public function max(string $max): static;

    /**
     * Set the min attribute.
     *
     * @param string $min e.g. "0".
     *
     * @return static
     */
    public function min(string $min): static;

    /**
     * Set the required attribute.
     *
     * @param boolean $required
     *
     * @return static
     */
    public function required(bool $required): static;

    /**
     * Set the step attribute.
     *
     * @param string $step e.g. "1".
     *
     * @return static
     */
    public function step(string $step): static;

    #endregion
}
