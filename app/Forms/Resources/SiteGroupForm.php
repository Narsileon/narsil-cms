<?php

namespace App\Forms\Resources;

#region USE

use App\Contracts\Fields\Text\TextFieldSettings;
use App\Contracts\Forms\Resources\SiteGroupForm as Contract;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function content(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteGroup::NAME,
                Field::NAME => trans('validation.attributes.name'),
                Field::SETTINGS => app(TextFieldSettings::class)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteGroup::ID,
                Field::NAME => trans('validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => SiteGroup::CREATED_AT,
                Field::NAME => trans('validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => SiteGroup::UPDATED_AT,
                Field::NAME => trans('validation.attributes.updated_at'),
            ]),
        ];
    }

    #endregion
}
