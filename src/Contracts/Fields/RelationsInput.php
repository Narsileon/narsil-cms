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
     * @param int $columns
     *
     * @return static Returns the current object instance.
     */
    public function columns(int $columns): static;

    /**
     * @param array $form
     *
     * @return static Returns the current object instance.
     */
    public function form(array $form): static;

    /**
     * @param boolean $multiple
     *
     * @return static Returns the current object instance.
     */
    public function multiple(bool $multiple): static;

    /**
     * @param array $options
     *
     * @return static Returns the current object instance.
     */
    public function options(array $options): static;

    /**
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
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
     * @param array $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    /**
     * @param array $widthOptions
     *
     * @return static Returns the current object instance.
     */
    public function widthOptions(array $widthOptions): static;

    /**
     * @param boolean $unique
     *
     * @return static Returns the current object instance.
     */
    public function unique(bool $unique): static;

    #endregion

    #endregion
}
