<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface RelationsInput extends Field
{
    #region PUBLIC METHODS

    /**
     * @param string $createUrl
     *
     * @return static Returns the current object instance.
     */
    public function createUrl(string $createUrl): static;

    /**
     * @param int $columns
     *
     * @return static Returns the current object instance.
     */
    public function columns(int $columns): static;

    /**
     * @param string $labelKey
     *
     * @return static Returns the current object instance.
     */
    public function labelKey(string $labelKey): static;

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
     * @param array $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    /**
     * @param string $valueKey
     *
     * @return static Returns the current object instance.
     */
    public function valueKey(string $valueKey): static;

    #endregion
}
