<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class ForgotPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = route('password.email');
        $this->description = trans('narsil::ui.reset_password');
        $this->submitLabel = trans('narsil::ui.send');
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
                Field::DESCRIPTION => trans('narsil::passwords.instruction'),
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::TYPE => EmailInput::class,
                Field::SETTINGS => app(EmailInput::class)
                    ->setAutoComplete(AutoCompleteEnum::EMAIL)
                    ->setIcon('email')
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
