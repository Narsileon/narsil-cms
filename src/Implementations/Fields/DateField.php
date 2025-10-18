<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\DateField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class DateField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->props['type'] = 'date';

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
                Field::SETTINGS => app(Contract::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max" : 'max',
                Field::NAME => trans('narsil::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'date';
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
