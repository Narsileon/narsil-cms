<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(User::TABLE));
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
                TemplateTab::HANDLE => 'account',
                TemplateTab::LABEL => trans('narsil::ui.account'),
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
            [
                TemplateTab::HANDLE => 'profile',
                TemplateTab::LABEL => trans('narsil::ui.profile'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
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
                    [
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
                        TemplateTabElement::HANDLE => User::AVATAR,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.avatar'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'roles',
                TemplateTab::LABEL => ModelService::getTableLabel(Role::TABLE),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => User::RELATION_ROLES,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.roles'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => CheckboxField::class,
                            Field::RELATION_OPTIONS => Role::selectOptions(),
                            Field::SETTINGS => app(CheckboxField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
