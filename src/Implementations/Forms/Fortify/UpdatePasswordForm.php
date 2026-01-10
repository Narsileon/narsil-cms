<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\UpdatePasswordForm as Contract;
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
            ->action(route('user-password.update'))
            ->method(RequestMethodEnum::PUT->value)
            ->submitIcon('save')
            ->submitLabel(trans('narsil::ui.save'));
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
                        TemplateTabElement::HANDLE => AutoCompleteEnum::USERNAME->value,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.email'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::USERNAME->value)
                                ->type('hidden'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::ATTRIBUTE_CURRENT_PASSWORD,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.current_password'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value),
                        ],
                    ],
                    [
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
                        TemplateTabElement::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.password_confirmation'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
