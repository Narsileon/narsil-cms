<?php

namespace Narsil\Implementations\FormElements;

#region USE

use Narsil\Contracts\FormElements\RangeInput as Contract;
use Narsil\Enums\Fields\InputTypeEnum;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Implementations\AbstractFormElement;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RangeInput extends AbstractFormElement implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(InputTypeEnum::RANGE->value);

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
        $this->settings[PropEnum::MAX->value] = $max;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function min(float|int $min): static
    {
        $this->settings[PropEnum::MIN->value] = $min;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function step(float|int $step): static
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
