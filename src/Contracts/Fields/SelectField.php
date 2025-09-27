<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface SelectField extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function setDefaultValue(string $value): static;

    /**
     * Set the multiple attribute.
     *
     * @param boolean $multiple
     *
     * @return static
     */
    public function setMultiple(bool $multiple): static;

    /**
     * Set the options attribute.
     *
     * @param array $options
     *
     * @return static
     */
    public function setOptions(array $options): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function setPlaceholder(string $placeholder): static;

    /**
     * Set the reload attribute.
     *
     * @param string $reload
     *
     * @return static
     */
    public function setReload(string $reload): static;

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
