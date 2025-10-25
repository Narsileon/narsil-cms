<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Forms\Fortify\LoginForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->setAction(route('login'))
            ->setDescription(trans('narsil::ui.connection'))
            ->setSubmitLabel(trans('narsil::ui.log_in'))
            ->setTitle(trans('narsil::ui.connection'));
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
                    ->setAutoComplete(AutoCompleteEnum::EMAIL)
                    ->setIcon('email')
                    ->setPlaceholder('email@example.com')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::PASSWORD,
                Field::NAME => trans('narsil::validation.attributes.password'),
                Field::TYPE => PasswordField::class,
                Field::SETTINGS => app(PasswordField::class)
                    ->setAppend(view('narsil::components.link', [
                        'label' => trans("narsil::passwords.link"),
                        'route' => route("password.request"),
                    ])->render())
                    ->setAutoComplete(AutoCompleteEnum::CURRENT_PASSWORD)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::REMEMBER,
                Field::NAME => trans('narsil::validation.attributes.remember'),
                Field::TYPE => CheckboxField::class,
                Field::SETTINGS => app(CheckboxField::class)
                    ->setClassName('flex-row-reverse justify-end'),
            ]),
        ];
    }

    #endregion
}
