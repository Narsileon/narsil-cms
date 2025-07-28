<?php

namespace Narsil\Implementations\FormElements;

#region USE

use Narsil\Contracts\FormElements\NumberInput;
use Narsil\Contracts\FormElements\TextInput as Contract;
use Narsil\Enums\Fields\InputTypeEnum;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Implementations\AbstractFormElement;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TextInput extends AbstractFormElement implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(InputTypeEnum::TEXT->value);

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
                Field::HANDLE => 'min_length',
                Field::NAME => trans('narsil-cms::validation.attributes.min_length'),
                Field::SETTINGS => app(NumberInput::class)
                    ->max('255')
                    ->min('0')
                    ->step('1')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'max_length',
                Field::NAME => trans('narsil-cms::validation.attributes.max_length'),
                Field::SETTINGS => app(NumberInput::class)
                    ->max('255')
                    ->min('0')
                    ->step('1')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
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
        return 'text-cursor-input';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.text');
    }

    /**
     * {@inheritDoc}
     */
    final public function autoComplete(string $autoComplete): static
    {
        $this->settings[PropEnum::AUTO_COMPLETE->value] = $autoComplete;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function maxLength(string $maxLength): static
    {
        $this->settings[PropEnum::MAX_LENGTH->value] = $maxLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function minLength(string $minLength): static
    {
        $this->settings[PropEnum::MIN_LENGTH->value] = $minLength;

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
    final public function value(string $value): static
    {
        $this->settings[PropEnum::VALUE->value] = $value;

        return $this;
    }

    #endregion
}
