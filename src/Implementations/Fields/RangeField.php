<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\NumberField;
use Narsil\Cms\Contracts\Fields\RangeField as Contract;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

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

        parent::__construct();
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
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.default_value'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(0),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.min" : 'min',
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.min'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(0),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.max" : 'max',
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.max'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class)
                        ->defaultValue(100),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.step" : 'step',
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.step'),
                BlockElement::RELATION_BASE => [
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
