<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\ArrayField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ArrayField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        app(TranslationsBag::class)
            ->add('narsil::ui.add')
            ->add('narsil::ui.move_down')
            ->add('narsil::ui.move_up')
            ->add('narsil::ui.remove');

        $this->defaultValue([]);
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
    final public function defaultValue(array $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function form(array $form): static
    {
        $this->set('form', $form);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function labelKey(string $labelKey): static
    {
        $this->set('labelKey', $labelKey);

        return $this;
    }

    #endregion

    #endregion
}
