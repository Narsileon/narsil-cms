<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\FileInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\ProfileForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ProfileForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->method = MethodEnum::PUT;
        $this->submitLabel = trans('narsil::ui.update');
        $this->url = route('user-profile-information.update');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        return [
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil::validation.attributes.last_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->icon('circle-user')
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil::validation.attributes.first_name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->icon('circle-user')
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => User::AVATAR,
                Field::NAME => trans('narsil::validation.attributes.avatar'),
                Field::TYPE => FileInput::class,
                Field::SETTINGS => app(FileInput::class)
                    ->accept('image/*')
                    ->icon('image'),
            ]),
        ];
    }

    #endregion
}
