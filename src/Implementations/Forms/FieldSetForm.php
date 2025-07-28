<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\FormElements\TextInput;
use Narsil\Contracts\Forms\FieldSetForm as Contract;
use Narsil\Implementations\AbstractForm;
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
    public function elements(): array
    {
        return [
            $this->main([
                [
                    Field::HANDLE => FieldSet::NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => FieldSet::HANDLE,
                    Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
            ]),
            $this->information([
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
            ]),
        ];
    }

    #endregion
}
