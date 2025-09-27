<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface ArrayField extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function setDefaultValue(array $value): static;

    /**
     * Set the form attribute.
     *
     * @param array $form
     *
     * @return static
     */
    public function setForm(array $form): static;

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
