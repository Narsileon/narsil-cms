<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Forms\Fortify\ConfirmPasswordForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class ConfirmPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setAction(route('password.confirm'))
            ->setDescription(trans('narsil::ui.confirm_password'))
            ->setSubmitLabel(trans('narsil::ui.confirm'))
            ->setTitle(trans('narsil::ui.confirm_password'));
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
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
