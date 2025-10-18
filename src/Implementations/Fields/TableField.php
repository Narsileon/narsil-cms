<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TableField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TableField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultValue([]);

        app(TranslationsBag::class)
            ->add('narsil::ui.move')
            ->add('narsil::ui.remove');
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

    #region • SETTERS

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
