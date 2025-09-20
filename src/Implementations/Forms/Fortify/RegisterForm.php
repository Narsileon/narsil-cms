<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\RegisterForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RegisterForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = route('register');
        $this->description = trans('narsil::ui.registration');
        $this->submitLabel = trans('narsil::ui.register');
        $this->title = trans('narsil::ui.registration');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            new Field([
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::TYPE => EmailInput::class,
                Field::SETTINGS => app(EmailInput::class)
                    ->setIcon('email')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setClassName('col-span-6')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setClassName('col-span-6')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil::validation.attributes.first_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                    ->setClassName('col-span-6')
                    ->setIcon('circle-user')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil::validation.attributes.last_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                    ->setClassName('col-span-6')
                    ->setIcon('circle-user')
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
