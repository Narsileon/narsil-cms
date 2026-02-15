<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Models\Policies\Role;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Fields\CheckboxField;
use Narsil\Cms\Contracts\Fields\EmailField;
use Narsil\Cms\Contracts\Fields\FileField;
use Narsil\Cms\Contracts\Fields\PasswordField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\UserForm as Contract;
use Narsil\Cms\Enums\Forms\AutoCompleteEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\ModelService;

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
                TemplateTab::LABEL => trans('narsil-cms::ui.account'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => User::EMAIL,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.email'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->icon('email'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::PASSWORD,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.password'),
                        TemplateTabElement::REQUIRED => !$this->model,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.password_confirmation'),
                        TemplateTabElement::REQUIRED => !$this->model,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'profile',
                TemplateTab::LABEL => trans('narsil-cms::ui.profile'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => User::LAST_NAME,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.last_name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                                ->icon('circle-user'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::FIRST_NAME,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.first_name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                                ->icon('circle-user'),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => User::AVATAR,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.avatar'),
                        TemplateTabElement::RELATION_BASE => [
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
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.roles'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => CheckboxField::class,
                            Field::RELATION_OPTIONS => Role::options(),
                            Field::SETTINGS => app(CheckboxField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
