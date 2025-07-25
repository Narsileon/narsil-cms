<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\SiteGroupForm as Contract;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Sites\SiteGroup;

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
    public function content(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteGroup::NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.name'),
                Field::SETTINGS => app(TextField::class)
                    ->required(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function meta(): array
    {
        return [
            new Field([
                Field::HANDLE => SiteGroup::ID,
                Field::NAME => trans('narsil-cms::validation.attributes.id'),
            ]),
            new Field([
                Field::HANDLE => SiteGroup::CREATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
            ]),
            new Field([
                Field::HANDLE => SiteGroup::UPDATED_AT,
                Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
            ]),
        ];
    }

    #endregion
}
