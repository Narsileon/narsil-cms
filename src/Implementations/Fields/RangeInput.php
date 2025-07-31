<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberInput;
use Narsil\Contracts\Fields\RangeInput as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RangeInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->value([0]);
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
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'max',
                Field::NAME => trans('narsil-cms::validation.attributes.max'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'step',
                Field::NAME => trans('narsil-cms::validation.attributes.step'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->min('0')
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'settings-2';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.range');
    }

    /**
     * {@inheritDoc}
     */
    final public function max(float|int $max): static
    {
        $this->settings['max'] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(float|int $min): static
    {
        $this->settings['min'] = $min;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function step(float|int $step): static
    {
        $this->settings['step'] = $step;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(array $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
