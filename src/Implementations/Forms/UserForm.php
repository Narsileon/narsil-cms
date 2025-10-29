<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\PasswordField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setDescription(trans('narsil::models.' . User::class))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.' . User::class));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $isPost = $this->method === MethodEnum::POST->value;

        $roleSelectOptions = static::getRoleSelectOptions();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::NAME => trans('narsil::ui.account'),
                        Block::RELATION_ELEMENTS => [
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::EMAIL,
                                    Field::NAME => trans('narsil::validation.attributes.email'),
                                    Field::TYPE => EmailField::class,
                                    Field::SETTINGS => app(EmailField::class)
                                        ->setIcon('email')
                                        ->setRequired(true),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::PASSWORD,
                                    Field::NAME => trans('narsil::validation.attributes.password'),
                                    Field::TYPE => PasswordField::class,
                                    Field::SETTINGS => app(PasswordField::class)
                                        ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                                        ->setRequired($isPost),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                                    Field::NAME => trans('narsil::validation.attributes.password_confirmation'),
                                    Field::TYPE => PasswordField::class,
                                    Field::SETTINGS => app(PasswordField::class)
                                        ->setAutoComplete(AutoCompleteEnum::NEW_PASSWORD)
                                        ->setRequired($isPost),
                                ])
                            ]),
                        ],
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::NAME => trans('narsil::ui.profile'),
                        Block::RELATION_ELEMENTS => [
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::LAST_NAME,
                                    Field::NAME => trans('narsil::validation.attributes.last_name'),
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class)
                                        ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                                        ->setIcon('circle-user')
                                        ->setRequired(true),
                                ]),
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::FIRST_NAME,
                                    Field::NAME => trans('narsil::validation.attributes.first_name'),
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class)
                                        ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                                        ->setIcon('circle-user')
                                        ->setRequired(true),
                                ]),
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::AVATAR,
                                    Field::NAME => trans('narsil::validation.attributes.avatar'),
                                    Field::TYPE => FileField::class,
                                    Field::SETTINGS => app(FileField::class)
                                        ->setAccept('image/*')
                                        ->setIcon('image'),
                                ]),
                            ]),
                        ],
                    ]),
                ]),
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'roles',
                TemplateSection::NAME => trans('narsil::tables.roles'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT =>
                        new Field([
                            Field::HANDLE => User::RELATION_ROLES,
                            Field::NAME => trans('narsil::validation.attributes.roles'),
                            Field::TYPE => CheckboxField::class,
                            Field::SETTINGS => app(CheckboxField::class)
                                ->setOptions($roleSelectOptions),
                        ]),
                    ]),
                ],
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the role select options.
     *
     * @return array<SelectOption>
     */
    protected static function getRoleSelectOptions(): array
    {
        return Role::query()
            ->orderBy(Role::NAME)
            ->get()
            ->map(function (Role $role)
            {
                $option = new SelectOption()
                    ->optionLabel($role->{Role::NAME})
                    ->optionValue($role->{Role::HANDLE});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
