<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->setAction(route('user-password.update'))
            ->setMethod(MethodEnum::PUT)
            ->setSubmitIcon('save')
            ->setSubmitLabel(trans('narsil::ui.save'));
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
                Field::HANDLE => AutoCompleteEnum::USERNAME->value,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setAutoComplete(AutoCompleteEnum::USERNAME)
                    ->setType('hidden'),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_CURRENT_PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.current_password'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->setAutoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
