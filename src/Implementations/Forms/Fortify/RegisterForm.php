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
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
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
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => User::EMAIL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.email'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->icon('email'),
                        ],
                    ],
                    [
                        TemplateTabElement::CLASS_NAME => 'col-span-6',
                        TemplateTabElement::HANDLE => User::PASSWORD,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.password'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                    [
                        TemplateTabElement::CLASS_NAME => 'col-span-6',
                        TemplateTabElement::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.password_confirmation'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                    [
                        TemplateTabElement::CLASS_NAME => 'col-span-6',
                        TemplateTabElement::HANDLE => User::FIRST_NAME,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.first_name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                                ->icon('circle-user'),
                        ],
                    ],
                    [
                        TemplateTabElement::CLASS_NAME => 'col-span-6',
                        TemplateTabElement::HANDLE => User::LAST_NAME,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.last_name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                                ->icon('circle-user'),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
