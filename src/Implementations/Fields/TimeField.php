<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\TimeField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TimeField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'time');

        $this->defaultValue('');
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
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min" : 'min',
                Field::NAME => trans('narsil::validation.attributes.min'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->defaultValue('00:00'),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->defaultValue('23:59'),
            ]),
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(string $value): static
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
    final public function required(bool $required): static
    {
        $this->set('required', $required);

        return $this;
    }

    #endregion

    #endregion
}
