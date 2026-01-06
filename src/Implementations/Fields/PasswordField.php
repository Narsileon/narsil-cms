<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\PasswordField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\Field;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PasswordField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'password');

        $this->defaultValue('');

        app(TranslationsBag::class)
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
                Field::HANDLE => Field::PLACEHOLDER,
                Field::LABEL => trans('narsil::validation.attributes.placeholder'),
                Field::TRANSLATABLE => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.min_length" : 'min_length',
                Field::LABEL => trans('narsil::validation.attributes.min_length'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(NumberField::class)
                    ->max(255)
                    ->min(0)
                    ->step(1)
                    ->defaultValue(0),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.max_length" : 'max_length',
                Field::LABEL => trans('narsil::validation.attributes.max_length'),
                Field::TYPE => NumberField::class,
                Field::SETTINGS => app(NumberField::class)
                    ->max(255)
                    ->min(0)
                    ->step(1)
                    ->defaultValue(255),
            ]),
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function autoComplete(string $autoComplete): static
    {
        $this->set('autoComplete', $autoComplete);

        return $this;
    }

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
    final public function icon(string $icon): static
    {
        $this->set('icon', $icon);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function maxLength(string $maxLength): static
    {
        $this->set('maxLength', $maxLength);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function minLength(string $minLength): static
    {
        $this->set('minLength', $minLength);

        return $this;
    }

    #endregion

    #endregion
}
