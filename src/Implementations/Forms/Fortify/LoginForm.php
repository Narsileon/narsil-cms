<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Forms\Fortify\LoginForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class LoginForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = route('login');
        $this->description = trans('narsil::ui.connection');
        $this->submitLabel = trans('narsil::ui.log_in');
        $this->title = trans('narsil::ui.connection');
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
                Field::HANDLE => User::EMAIL,
                Field::NAME => trans('narsil::validation.attributes.email'),
                Field::TYPE => EmailInput::class,
                Field::SETTINGS => app(EmailInput::class)
                    ->setAutoComplete(AutoCompleteEnum::EMAIL)
                    ->setIcon('email')
                    ->setPlaceholder('email@example.com')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordInput::class,
                Field::SETTINGS => app(PasswordInput::class)
                    ->setAutoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::REMEMBER,
                Field::NAME => trans('narsil::validation.attributes.remember'),
                Field::TYPE => CheckboxInput::class,
                Field::SETTINGS => app(CheckboxInput::class)
                    ->setClassName('flex-row-reverse justify-end'),
            ]),
        ];
    }

    #endregion
}
