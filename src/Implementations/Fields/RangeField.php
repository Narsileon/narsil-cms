<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberField;
use Narsil\Contracts\Fields\RangeField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RangeField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultValue([0]);
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
                Field::SETTINGS => app(NumberField::class)
                    ->setDefaultValue(0),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min" : 'min',
                Field::NAME => trans('narsil::validation.attributes.min'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(NumberField::class)
                    ->setDefaultValue(0),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(NumberField::class)
                    ->setDefaultValue(100),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.step" : 'step',
                Field::NAME => trans('narsil::validation.attributes.step'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(NumberField::class)
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
        return 'range';
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
    final public function setMax(float|int $max): static
    {
        $this->props['max'] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMin(float|int $min): static
    {
        $this->props['min'] = $min;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setStep(float|int $step): static
    {
        $this->props['step'] = $step;

        return $this;
    }

    #endregion

    #endregion
}
