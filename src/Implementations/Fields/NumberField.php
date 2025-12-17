<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

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
                    ->defaultValue(0),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'settings.max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->defaultValue(999999999),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.step" : 'settings.step',
                Field::NAME => trans('narsil::validation.attributes.step'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->min(0)
                    ->defaultValue(1),
            ]),
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
    final public function placeholder(string $placeholder): static
    {
        $this->set('placeholder', $placeholder);

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
