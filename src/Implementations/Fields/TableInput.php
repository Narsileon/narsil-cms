<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TableInput as Contract;
use Narsil\Implementations\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TableInput extends AbstractField implements Contract
{
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
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    final public function columns(array $columns): static
    {
        $this->settings['columns'] = $columns;

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
