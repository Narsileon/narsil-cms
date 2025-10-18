<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TreeField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TreeField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.add')
            ->add('narsil::ui.remove');

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
        return 'array';
    }

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(array $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    #endregion

    #endregion
}
