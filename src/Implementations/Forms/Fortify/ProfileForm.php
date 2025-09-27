<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\ProfileForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\User;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

        $this->action = route('user-profile-information.update');
        $this->method = MethodEnum::PUT;
        $this->submitIcon = 'save';
        $this->submitLabel = trans('narsil::ui.save');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::NAME => trans('narsil::validation.attributes.last_name'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setAutoComplete(AutoCompleteEnum::FAMILY_NAME)
                    ->setIcon('circle-user')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::NAME => trans('narsil::validation.attributes.first_name'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setAutoComplete(AutoCompleteEnum::GIVEN_NAME)
                    ->setIcon('circle-user')
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => User::AVATAR,
                Field::NAME => trans('narsil::validation.attributes.avatar'),
                Field::TYPE => FileField::class,
                Field::SETTINGS => app(FileField::class)
                    ->setAccept('image/*')
                    ->setIcon('image'),
            ]),
        ];
    }

    #endregion
}
