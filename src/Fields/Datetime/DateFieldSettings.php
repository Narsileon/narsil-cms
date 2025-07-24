<?php

namespace Narsil\Fields\Datetime;

#region USE

use Narsil\Contracts\Fields\Datetime\DateFieldSettings as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\FieldSettings;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class DateFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::DATE->value);

        $this->value('');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getForm(): array
    {
        return [
            new Field([
                Field::HANDLE => 'min',
                Field::NAME => trans('validation.attributes.min'),
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'max',
                Field::NAME => trans('validation.attributes.max'),
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    final public function max(string $max): static
    {
        $this->settings[PropEnum::MAX->value] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(string $min): static
    {
        $this->settings[PropEnum::MIN->value] = $min;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->settings[PropEnum::REQUIRED->value] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(string $value): static
    {
        $this->settings[PropEnum::VALUE->value] = $value;

        return $this;
    }

    #endregion
}
