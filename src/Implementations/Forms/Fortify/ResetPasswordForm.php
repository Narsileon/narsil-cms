<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Contracts\Forms\Fortify\ResetPasswordForm as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->setAction(route('password.update'))
            ->setDescription(trans('narsil::ui.reset_password'))
            ->setSubmitLabel(trans('narsil::ui.reset'))
            ->setTitle(trans('narsil::ui.reset_password'));
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
                Field::TYPE => EmailField::class,
                Field::SETTINGS => app(EmailField::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->icon('email')
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
