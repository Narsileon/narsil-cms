<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\FileInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\User;

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

        $this->description = trans('narsil-cms::ui.user');
        $this->title = trans('narsil-cms::ui.user');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $isPost = $this->method === MethodEnum::POST->value;

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::NAME => trans('narsil-cms::ui.account'),
                        Block::RELATION_ELEMENTS => [
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::EMAIL,
                                    Field::NAME => trans('narsil-cms::validation.attributes.email'),
                                    Field::TYPE => EmailInput::class,
                                    Field::SETTINGS => app(EmailInput::class)
                                        ->required(true),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::PASSWORD,
                                    Field::NAME => trans('narsil-cms::validation.attributes.password'),
                                    Field::TYPE => PasswordInput::class,
                                    Field::SETTINGS => app(PasswordInput::class)
                                        ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                                        ->required($isPost),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                                    Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                                    Field::TYPE => PasswordInput::class,
                                    Field::SETTINGS => app(PasswordInput::class)
                                        ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                                        ->required($isPost),
                                ])
                            ]),
                        ],
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::NAME => trans('narsil-cms::ui.profile'),
                        Block::RELATION_ELEMENTS => [
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::LAST_NAME,
                                    Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                                    Field::TYPE => TextInput::class,
                                    Field::SETTINGS => app(TextInput::class)
                                        ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                                        ->required(true),
                                ]),
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::FIRST_NAME,
                                    Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                                    Field::TYPE => TextInput::class,
                                    Field::SETTINGS => app(TextInput::class)
                                        ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                                        ->required(true),
                                ]),
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => User::AVATAR,
                                    Field::NAME => trans('narsil-cms::validation.attributes.avatar'),
                                    Field::TYPE => FileInput::class,
                                    Field::SETTINGS => app(FileInput::class)
                                        ->accept('image/*'),
                                ]),
                            ]),
                        ],
                    ]),
                ]),
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'roles',
                TemplateSection::NAME => trans('narsil-cms::ui.roles'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT =>
                        new Field([
                            Field::HANDLE => User::RELATION_ROLES,
                            Field::NAME => trans('narsil-cms::validation.attributes.roles'),
                            Field::TYPE => CheckboxInput::class,
                            Field::SETTINGS => app(CheckboxInput::class),
                        ]),
                    ]),
                ],
            ]),
            static::informationSection(),
        ];
    }

    #endregion
}
