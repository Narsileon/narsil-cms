<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\DateField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DateField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'date');

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
            [
                BlockElement::HANDLE => $prefix ? "$prefix.value" : 'value',
                BlockElement::LABEL => trans('narsil::validation.attributes.default_value'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.min" : 'min',
                BlockElement::LABEL => trans('narsil::validation.attributes.min'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
            [
                Field::HANDLE => $prefix ? "$prefix.max" : 'max',
                Field::LABEL => trans('narsil::validation.attributes.max'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
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

    #endregion

    #endregion
}
