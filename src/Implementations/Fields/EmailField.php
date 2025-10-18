<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\EmailField as Contract;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EmailField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->props['type'] = 'email';

        $this->setDefaultvalue('');
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
                Field::HANDLE => $prefix ? "$prefix.placeholder" : ' placeholder',
                Field::NAME => trans('narsil::validation.attributes.placeholder'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
            ]),
            new Field([
                Field::HANDLE => $prefix ? "$prefix.multiple" : 'multiple',
                Field::NAME => trans('narsil::validation.attributes.multiple'),
                Field::TYPE => SwitchField::class,
                Field::SETTINGS => app(SwitchField::class),
            ]),

        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'email';
    }

    #region • SETTERS

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
    final public function setMultiple(bool $multiple): static
    {
        $this->props['multiple'] = $multiple;

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
