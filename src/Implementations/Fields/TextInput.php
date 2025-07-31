<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\NumberInput;
use Narsil\Contracts\Fields\TextInput as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TextInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('text');
        $this->value('');
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
                Field::HANDLE => $prefix ? "$prefix.min_length" : 'min_length',
                Field::NAME => trans('narsil-cms::validation.attributes.min_length'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->max(255)
                    ->min(0)
                    ->step(1)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max_length" : 'max_length',
                Field::NAME => trans('narsil-cms::validation.attributes.max_length'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->max(255)
                    ->min(0)
                    ->step(1)
                    ->value(255)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.placeholder" : 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
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
        $this->settings['autoComplete'] = $autoComplete;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function maxLength(string $maxLength): static
    {
        $this->settings['maxLength'] = $maxLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function minLength(string $minLength): static
    {
        $this->settings['minLength'] = $minLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->settings['placeholder'] = $placeholder;

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
