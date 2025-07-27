<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\FieldSetForm as Contract;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldSet;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            [
                FieldSet::HANDLE => self::MAIN,
                FieldSet::NAME => trans('narsil-cms::ui.main'),
                FieldSet::RELATION_ITEMS => [
                    [
                        Field::HANDLE => FieldSet::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => FieldSet::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::SETTINGS => app(TextField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                ],
            ],
            [
                FieldSet::HANDLE => self::SIDEBAR_INFORMATION,
                FieldSet::RELATION_ITEMS => [
                    [
                        Field::HANDLE => Field::ID,
                        Field::NAME => trans('narsil-cms::validation.attributes.id'),
                    ],
                    [
                        Field::HANDLE => Field::CREATED_AT,
                        Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                    ],
                    [
                        Field::HANDLE => Field::UPDATED_AT,
                        Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                    ],
                ],
            ],
        ];
    }

    #endregion
}
