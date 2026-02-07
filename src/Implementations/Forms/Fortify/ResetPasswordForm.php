<?php

namespace Narsil\Cms\Implementations\Forms\Fortify;

#region USE

use Narsil\Cms\Contracts\Fields\EmailField;
use Narsil\Cms\Contracts\Fields\PasswordField;
use Narsil\Cms\Enums\Forms\AutoCompleteEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Contracts\Forms\Fortify\ResetPasswordForm as Contract;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ResetPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->action(route('password.update'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-cms::ui.reset'));
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
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.email'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->autoComplete(AutoCompleteEnum::EMAIL->value)
                                ->icon('email'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::PASSWORD,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.password'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.password_confirmation'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
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
