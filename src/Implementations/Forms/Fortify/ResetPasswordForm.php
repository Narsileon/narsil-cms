<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Contracts\Forms\Fortify\ResetPasswordForm as Contract;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Models\Structures\Field;
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
            ->action(route('password.update'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.reset'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::REQUIRED => true,
                Field::TYPE => EmailField::class,
                Field::SETTINGS => app(EmailField::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->icon('email'),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::REQUIRED => true,
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::REQUIRED => true,
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
            ]),
        ];
    }

    #endregion
}
