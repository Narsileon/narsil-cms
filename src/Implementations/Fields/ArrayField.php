<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\ArrayField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
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

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'array';
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
    final public function block(Block $block): static
    {
        $this->set('block', $block);

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

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->set('required', $required);

        return $this;
    }

    #endregion

    #endregion
}
