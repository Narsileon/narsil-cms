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
        $this->props['type'] = 'time';

        $this->setDefaultValue('');
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
                    ->setDefaultValue('00:00'),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->setDefaultValue('23:59'),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'time';
    }

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(string $value): static
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
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

        return $this;
    }

    #endregion

    #endregion
}
