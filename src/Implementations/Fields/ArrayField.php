<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\ArrayField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

    #region • FLUENT METHODS

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
    final public function setBlock(Block $block): static
    {
        $this->props['block'] = $block;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setLabelKey(string $labelKey): static
    {
        $this->props['labelKey'] = $labelKey;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

        return $this;
    }

    #endregion

    #endregion
}
