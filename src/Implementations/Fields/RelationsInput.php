<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\RelationsInput as Contract;
use Narsil\Implementations\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RelationsInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->value([]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'layers';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.relations');
    }

    /**
     * {@inheritDoc}
     */
    final public function columns(int $columns): static
    {
        $this->settings['columns'] = $columns;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function dataPath(string $dataPath): static
    {
        $this->settings['dataPath'] = $dataPath;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function labelKey(string $labelKey): static
    {
        $this->settings['labelKey'] = $labelKey;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->settings['multiple'] = $multiple;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->settings['options'] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->settings['placeholder'] = $placeholder;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(array $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
