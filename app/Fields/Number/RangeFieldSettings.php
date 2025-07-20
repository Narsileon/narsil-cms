<?php

namespace App\Fields\Number;

#region USE

use App\Contracts\Fields\Number\RangeFieldSettings as Contract;
use App\Enums\Fields\PropEnum;
use App\Enums\Fields\TypeEnum;
use App\Fields\FieldSettings;
use App\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RangeFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::RANGE->value);

        $this->value([0]);
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
            new Field([
                Field::HANDLE => 'step',
                Field::NAME => trans('validation.attributes.step'),
                Field::SETTINGS => app(Contract::class)
                    ->min('0')
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
    final public function step(string $step): static
    {
        $this->settings[PropEnum::STEP->value] = $step;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(array $value): static
    {
        $this->settings[PropEnum::VALUE->value] = $value;

        return $this;
    }

    #endregion
}
