<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Contracts\Forms\Fortify\ResetPasswordForm as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class ResetPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = route('password.update');
        $this->description = trans('narsil::ui.reset_password');
        $this->submitLabel = trans('narsil::ui.reset');
        $this->title = trans('narsil::ui.reset_password');
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
                    ->setAutoComplete(AutoCompleteEnum::EMAIL)
                    ->setIcon('email')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
