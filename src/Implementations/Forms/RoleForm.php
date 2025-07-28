<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\FormElements\TextInput;
use Narsil\Contracts\Forms\FieldSetForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldSet;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        return [
            [
                FieldSet::HANDLE => self::MAIN,
                FieldSet::NAME => trans('narsil-cms::ui.main'),
                FieldSet::RELATION_ELEMENTS => [
                    [
                        Field::HANDLE => Role::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ],
                ],
            ],
            [
                FieldSet::HANDLE => self::SIDEBAR_INFORMATION,
                FieldSet::RELATION_ELEMENTS => [
                    [
                        Field::HANDLE => Role::ID,
                        Field::NAME => trans('narsil-cms::validation.attributes.id'),
                    ],
                    [
                        Field::HANDLE => Role::CREATED_AT,
                        Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                    ],
                    [
                        Field::HANDLE => Role::UPDATED_AT,
                        Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                    ],
                ],
            ],
        ];
    }

    #endregion
}
