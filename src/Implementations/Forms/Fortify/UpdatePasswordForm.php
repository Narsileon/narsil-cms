<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UpdatePasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->method = MethodEnum::PUT;
        $this->submitLabel = trans('narsil::ui.update');
        $this->url = route('user-password.update');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        return [
            new Field([
                Field::HANDLE => AutoCompleteEnum::USERNAME->value,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::USERNAME)
                    ->type('hidden'),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_CURRENT_PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.current_password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
