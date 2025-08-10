<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this->description = trans('narsil-cms::ui.reset_password');
        $this->submitLabel = trans('narsil-cms::ui.send');
        $this->title = trans('narsil-cms::ui.reset_password');
        $this->url = route('password.email');
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
                Field::DESCRIPTION => trans('narsil-cms::passwords.instruction'),
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil-cms::validation.attributes.email'),
                Field::TYPE => EmailInput::class,
                Field::SETTINGS => app(EmailInput::class)
                    ->autoComplete(AutoCompleteEnum::EMAIL->value)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
