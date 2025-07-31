<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\EmailInput as Contract;
use Narsil\Contracts\Fields\SwitchInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Implementations\Fields\TextInput as Input;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EmailInput extends Input implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('email');
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
                Field::HANDLE => 'multiple',
                Field::NAME => trans('narsil-cms::validation.attributes.multiple'),
                Field::TYPE => SwitchInput::class,
                Field::SETTINGS => app(SwitchInput::class)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'placeholder',
                Field::NAME => trans('narsil-cms::validation.attributes.placeholder'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'mail';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.email');
    }

    /**
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->settings['multiple'] = $multiple;

        return $this;
    }

    #endregion
}
