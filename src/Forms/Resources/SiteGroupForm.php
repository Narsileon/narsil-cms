<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\SiteGroupForm as Contract;
use Narsil\Enums\Fields\TypeEnum;
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
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            [
                Field::NAME => trans('narsil-cms::ui.main'),
                Field::TYPE => TypeEnum::TAB->value,
                Field::RELATION_FIELDS => [
                    [
                        Field::HANDLE => SiteGroup::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                ],
            ],
            [
                Field::TYPE => TypeEnum::DATA->value,
                Field::RELATION_FIELDS => [
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
                ],
            ],
        ];
    }

    #endregion
}
