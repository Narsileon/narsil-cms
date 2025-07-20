<?php

namespace App\Http\Forms\Resources;

#region USE

use App\Contracts\Fields\Text\TextFieldSettings;
use App\Contracts\Forms\Resources\SiteGroupForm as Contract;
use App\Http\Forms\AbstractForm;
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
    protected function getContent(): array
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

    #endregion
}
