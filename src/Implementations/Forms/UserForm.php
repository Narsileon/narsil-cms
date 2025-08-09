<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\EmailInput;
use Narsil\Contracts\Fields\PasswordInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\UserForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
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
        $this->description(trans('narsil-cms::ui.user'));
        $this->title(trans('narsil-cms::ui.user'));

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function form(): array
    {
        return [
            static::mainBlock([
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
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => User::ATTRIBUTE_PASSWORD_CONFIRMATION,
                        Field::NAME => trans('narsil-cms::validation.attributes.password_confirmation'),
                        Field::TYPE => PasswordInput::class,
                        Field::SETTINGS => app(PasswordInput::class)
                            ->autoComplete(AutoCompleteEnum::NEW_PASSWORD->value)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => User::FIRST_NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.first_name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => User::LAST_NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.last_name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                            ->required(true),
                    ])
                ]),
            ]),
            static::informationBlock(),
        ];
    }

    #endregion
}
