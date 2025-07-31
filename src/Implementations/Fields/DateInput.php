<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\DateInput as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DateInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('date');
        $this->value('');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(): array
    {
        return [
            new Field([
                Field::HANDLE => 'min',
                Field::NAME => trans('narsil-cms::validation.attributes.min'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'max',
                Field::NAME => trans('narsil-cms::validation.attributes.max'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'calendar';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.date');
    }

    /**
     * {@inheritDoc}
     */
    final public function max(string $max): static
    {
        $this->settings['max'] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(string $min): static
    {
        $this->settings['min'] = $min;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->settings['required'] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(string $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
