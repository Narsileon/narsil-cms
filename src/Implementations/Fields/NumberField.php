<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class NumberField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->props['type'] = 'number';

        $this->setDefaultValue(0);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.value" : 'value',
                Field::NAME => trans('narsil::validation.attributes.default_value'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(Contract::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min" : 'min',
                Field::NAME => trans('narsil::validation.attributes.min'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->setDefaultValue(0),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'settings.max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->setDefaultValue(999999999),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.step" : 'settings.step',
                Field::NAME => trans('narsil::validation.attributes.step'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->setMin(0)
                    ->setDefaultValue(1),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'number';
    }

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(float|int $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMax(string $max): static
    {
        $this->props['max'] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMin(string $min): static
    {
        $this->props['min'] = $min;

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

    /**
     * {@inheritDoc}
     */
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setStep(string $step): static
    {
        $this->props['step'] = $step;

        return $this;
    }

    #endregion

    #endregion
}
