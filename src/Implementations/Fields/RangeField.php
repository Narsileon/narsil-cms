<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberField;
use Narsil\Contracts\Fields\RangeField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RangeField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue([0]);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            [
                BlockElement::HANDLE => $prefix ? "$prefix.value" : 'value',
                BlockElement::LABEL => trans('narsil::validation.attributes.default_value'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(0),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.min" : 'min',
                BlockElement::LABEL => trans('narsil::validation.attributes.min'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(0),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.max" : 'max',
                BlockElement::LABEL => trans('narsil::validation.attributes.max'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(100),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.step" : 'step',
                BlockElement::LABEL => trans('narsil::validation.attributes.step'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->min(0)
                        ->defaultValue(1),
                ],
            ],
        ];
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
    final public function max(float|int $max): static
    {
        $this->set('max', $max);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(float|int $min): static
    {
        $this->set('min', $min);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function step(float|int $step): static
    {
        $this->set('step', $step);

        return $this;
    }

    #endregion

    #endregion
}
