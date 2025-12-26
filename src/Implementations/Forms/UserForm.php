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
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;
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
    protected function getLayout(): array
    {
        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'account',
                TemplateSection::NAME => trans('narsil::ui.account'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::EMAIL,
                            Field::NAME => trans('narsil::validation.attributes.email'),
                            Field::REQUIRED => true,
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->icon('email'),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::PASSWORD,
                            Field::NAME => trans('narsil::validation.attributes.password'),
                            Field::REQUIRED => true,
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                            Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                            Field::REQUIRED => true,
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value),
                        ]),
                    ]),
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'profile',
                TemplateSection::NAME => trans('narsil::ui.profile'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::LAST_NAME,
                            Field::NAME => trans('narsil::validation.attributes.last_name'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                                ->icon('circle-user'),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::FIRST_NAME,
                            Field::NAME => trans('narsil::validation.attributes.first_name'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                                ->icon('circle-user'),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => User::AVATAR,
                            Field::NAME => trans('narsil::validation.attributes.avatar'),
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ]),
                    ]),
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'roles',
                TemplateSection::NAME => ModelService::getTableLabel(Role::TABLE),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT =>
                        new Field([
                            Field::HANDLE => User::RELATION_ROLES,
                            Field::NAME => trans('narsil::validation.attributes.roles'),
                            Field::TYPE => CheckboxField::class,
                            Field::RELATION_OPTIONS => Role::selectOptions(),
                            Field::SETTINGS => app(CheckboxField::class),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
