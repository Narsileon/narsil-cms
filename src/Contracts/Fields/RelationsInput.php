<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface RelationsInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * Add an option.
     *
     * @param string $identifier
     * @param string $label
     * @param string $optionLabel
     * @param string $optionValue
     * @param array $options
     * @param array $routes
     *
     * @return static
     */
    public function addOption(
        string $identifier,
        string $label,
        string $optionLabel,
        string $optionValue,
        array $options = [],
        array $routes = [],
    ): static;

    /**
     * Set the columns.
     *
     * @param int $columns
     *
     * @return static
     */
    public function setColumns(int $columns): static;

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
     * Set the intermediate attribute.
     *
     * @param Field $relation
     * @param string $label
     * @param string $optionLabel
     * @param string $optionValue
     *
     * @return static
     */
    public function setIntermediate(
        Field $relation,
        string $label,
        string $optionLabel,
        string $optionValue,
    ): static;

    /**
     * Set the multiple attribute.
     *
     * @param boolean $multiple
     *
     * @return static
     */
    public function setMultiple(bool $multiple): static;

    /**
     * Set the options attribute
     * .
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
     * Set the width options.
     *
     * @param array $widthOptions
     *
     * @return static
     */
    public function setWidthOptions(array $widthOptions): static;

    /**
     * Set the unique attribute.
     *
     * @param boolean $unique
     *
     * @return static
     */
    public function setUnique(bool $unique): static;

    #endregion

    #endregion
}
