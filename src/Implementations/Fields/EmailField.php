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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EmailField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'email');

        $this->defaultvalue('');
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
    final public function multiple(bool $multiple): static
    {
        $this->set('multiple', $multiple);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->set('placeholder', $placeholder);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->set('required', $required);

        return $this;
    }

    #endregion

    #endregion
}
