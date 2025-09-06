<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\PasswordInput as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class PasswordInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->props['type'] = 'password';

        $this->setDefaultValue('');

        app(LabelsBag::class)
            ->add('narsil::accessibility.hide_password')
            ->add('narsil::accessibility.show_password');
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
                Field::HANDLE => $prefix ? "$prefix.placeholder" : 'placeholder',
                Field::NAME => trans('narsil::validation.attributes.placeholder'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min_length" : 'min_length',
                Field::NAME => trans('narsil::validation.attributes.min_length'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->setMax(255)
                    ->setMin(0)
                    ->setStep(1),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max_length" : 'max_length',
                Field::NAME => trans('narsil::validation.attributes.max_length'),
                Field::TYPE => NumberInput::class,
                Field::SETTINGS => app(NumberInput::class)
                    ->setMax(255)
                    ->setMin(0)
                    ->setStep(1)
                    ->setDefaultValue(255),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'password';
    }

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function setAutoComplete(AutoCompleteEnum $autoComplete): static
    {
        $this->props['autoComplete'] = $autoComplete->value;

        return $this;
    }

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
    final public function setIcon(string $icon): static
    {
        $this->props['icon'] = $icon;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMaxLength(string $maxLength): static
    {
        $this->props['maxLength'] = $maxLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setMinLength(string $minLength): static
    {
        $this->props['minLength'] = $minLength;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setPlaceholder(string $placeholder): static
    {
        $this->props['placeholder'] = $placeholder;

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
