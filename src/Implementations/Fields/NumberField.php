<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\NumberField as Contract;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NumberField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'number');

        $this->defaultValue(0);

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
                        ->defaultValue(999999999),
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
    final public function defaultValue(float|int $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function max(string $max): static
    {
        $this->set('max', $max);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(string $min): static
    {
        $this->set('min', $min);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function step(string $step): static
    {
        $this->set('step', $step);

        return $this;
    }

    #endregion

    #endregion
}
