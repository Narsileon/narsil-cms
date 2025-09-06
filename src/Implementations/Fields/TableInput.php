<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TableInput as Contract;
use Narsil\Implementations\AbstractField;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TableInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultValue([]);
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
        return 'table';
    }

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function setColumns(array $columns): static
    {
        $this->props['columns'] = $columns;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(array $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setPlaceholder(string $placeholder): static
    {
        $this->props['placeholder'] = $placeholder;

        return $this;
    }

    #endregion

    #endregion
}
