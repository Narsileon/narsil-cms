<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\ArrayField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Support\LabelsBag;

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
        app(LabelsBag::class)
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
        return 'relations';
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
    final public function setForm(array $form): static
    {
        $this->props['form'] = $form;

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
