<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\ProfileForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
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

        $this
            ->action(route('user-profile-information.update'))
            ->method(RequestMethodEnum::PUT->value)
            ->submitIcon('save')
            ->submitLabel(trans('narsil::ui.save'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => User::LAST_NAME,
                Field::LABEL => trans('narsil::validation.attributes.last_name'),
                Field::REQUIRED => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::FAMILY_NAME->value)
                    ->icon('circle-user'),
            ]),
            new Field([
                Field::HANDLE => User::FIRST_NAME,
                Field::LABEL => trans('narsil::validation.attributes.first_name'),
                Field::REQUIRED => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::GIVEN_NAME->value)
                    ->icon('circle-user'),
            ]),
            new Field([
                Field::HANDLE => User::AVATAR,
                Field::LABEL => trans('narsil::validation.attributes.avatar'),
                Field::TYPE => FileField::class,
                Field::SETTINGS => app(FileField::class)
                    ->accept('image/*')
                    ->icon('image'),
            ]),
        ];
    }

    #endregion
}
