<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;
use Narsil\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
 */
interface RelationsField extends Contract
{
    #region PUBLIC METHODS

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
    public function columns(int $columns): static;

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function defaultValue(array $value): static;

    /**
     * Set the form attribute.
     *
     * @param array $form
     *
     * @return static
     */
    public function form(array $form): static;

    /**
     * Set the intermediate attribute.
     *
     * @param array $relation
     * @param string $label
     * @param string $optionLabel
     * @param string $optionValue
     *
     * @return static
     */
    public function intermediate(
        array $relation,
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
    public function multiple(bool $multiple): static;

    /**
     * Set the options attribute
     * .
     * @param array $options
     *
     * @return static
     */
    public function options(array $options): static;

    /**
     * Set the unique attribute.
     *
     * @param boolean $unique
     *
     * @return static
     */
    public function unique(bool $unique): static;

    /**
     * Set the width options.
     *
     * @param array $widthOptions
     *
     * @return static
     */
    public function widthOptions(array $widthOptions): static;

    #endregion

    #endregion
}
