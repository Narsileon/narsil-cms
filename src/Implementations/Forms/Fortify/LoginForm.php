<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Forms\Fortify\LoginForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
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
            ->action(route('login'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.log_in'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        BlockElement::HANDLE => User::EMAIL,
                        BlockElement::LABEL => trans('narsil::validation.attributes.email'),
                        BlockElement::REQUIRED => true,
                        BlockElement::RELATION_ELEMENT => [
                            Field::PLACEHOLDER => 'email@example.com',
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->autoComplete(AutoCompleteEnum::EMAIL->value)
                                ->icon('email'),
                        ],
                    ],
                    [
                        BlockElement::HANDLE => User::PASSWORD,
                        BlockElement::LABEL => trans('narsil::validation.attributes.password'),
                        BlockElement::REQUIRED => true,
                        BlockElement::RELATION_ELEMENT => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->append(view('narsil::components.link', [
                                    'label' => trans("narsil::passwords.link"),
                                    'route' => route("password.request"),
                                ])->render())
                                ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value),
                        ],
                    ],
                    [
                        BlockElement::CLASS_NAME => 'flex-row-reverse justify-end',
                        BlockElement::HANDLE => User::REMEMBER,
                        BlockElement::LABEL => trans('narsil::validation.attributes.remember'),
                        BlockElement::RELATION_ELEMENT => [
                            Field::TYPE => CheckboxField::class,
                            Field::SETTINGS => app(CheckboxField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
