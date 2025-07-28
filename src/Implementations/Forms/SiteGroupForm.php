<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\FormElements\TextInput;
use Narsil\Contracts\Forms\SiteGroupForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Sites\SiteGroup;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteGroupForm extends AbstractForm implements Contract
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
                    Field::HANDLE => SiteGroup::NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
            ]),
            $this->information([
                [
                    Field::HANDLE => SiteGroup::ID,
                    Field::NAME => trans('narsil-cms::validation.attributes.id'),
                ],
                [
                    Field::HANDLE => SiteGroup::CREATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                ],
                [
                    Field::HANDLE => SiteGroup::UPDATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                ],
            ]),
        ];
    }

    #endregion
}
