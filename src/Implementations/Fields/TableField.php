<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TableField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TableField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue([]);

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

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function columns(array $columns): static
    {
        $this->set('columns', $columns);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(array $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->set('placeholder', $placeholder);

        return $this;
    }

    #endregion

    #endregion
}
