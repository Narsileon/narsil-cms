<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface NumberField extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * Set the default value.
     *
     * @param float|integer $value
     *
     * @return static
     */
    public function setDefaultValue(float|int $value): static;

    /**
     * Set the max attribute.
     *
     * @param string $max e.g. "100".
     *
     * @return static
     */
    public function setMax(string $max): static;

    /**
     * Set the min attribute.
     *
     * @param string $min e.g. "0".
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

    /**
     * Set the step attribute.
     *
     * @param string $step e.g. "1".
     *
     * @return static
     */
    public function setStep(string $step): static;

    #endregion

    #endregion
}
