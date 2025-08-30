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
        $this->type('password');
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
        return 'table';
    }

    #region • FLUENT METHODS

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

    #endregion
}
