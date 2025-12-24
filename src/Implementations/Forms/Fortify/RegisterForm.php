<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\RegisterForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->action(route('register'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.register'));
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
                    ->icon('email'),
            ]),
            new Field([
                Field::CLASS_NAME => 'col-span-6',
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::REQUIRED => true,
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
            ]),
            new Field([
                Field::CLASS_NAME => 'col-span-6',
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::REQUIRED => true,
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
            ]),
            new Field([
                Field::CLASS_NAME => 'col-span-6',
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil::validation.attributes.first_name'),
                Field::REQUIRED => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->icon('circle-user'),
            ]),
            new Field([
                Field::CLASS_NAME => 'col-span-6',
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil::validation.attributes.last_name'),
                Field::REQUIRED => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->icon('circle-user'),
            ]),
        ];
    }

    #endregion
}
