<?php

namespace Narsil\Fields\Number;

#region USE

use Narsil\Contracts\Fields\Number\NumberField as Contract;
use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Enums\Fields\InputTypeEnum;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Fields\AbstractField;
use Narsil\Models\Fields\Field;

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
        parent::__construct(
            icon: 'text-cursor-input',
            label: trans('narsil-cms::fields.number'),
            type: InputTypeEnum::NUMBER->value
        );

        $this->value(0);
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
                Field::NAME => trans('narsil-cms::validation.attributes.min'),
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'max',
                Field::NAME => trans('narsil-cms::validation.attributes.max'),
                Field::SETTINGS => app(Contract::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'step',
                Field::NAME => trans('narsil-cms::validation.attributes.step'),
                Field::SETTINGS => app(Contract::class)
                    ->min('0')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
                Field::SETTINGS => app(TextField::class)
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
    final public function placeholder(string $placeholder): static
    {
        $this->settings[PropEnum::PLACEHOLDER->value] = $placeholder;

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
    final public function step(string $step): static
    {
        $this->settings[PropEnum::STEP->value] = $step;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(float|int $value): static
    {
        $this->settings[PropEnum::VALUE->value] = $value;

        return $this;
    }

    #endregion
}
