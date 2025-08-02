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
     * @param int $columns
     *
     * @return static Returns the current object instance.
     */
    public function columns(int $columns): static;

    /**
     * @param string $dataPath
     *
     * @return static Returns the current object instance.
     */
    public function dataPath(string $dataPath): static;


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
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
     * @param array $value
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion
}
