<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\DatetimeField;
use Narsil\Contracts\Forms\PermissionForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\TemplateTab;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        BlockElement::CLASS_NAME => 'flex-row justify-between',
                        BlockElement::HANDLE => Entity::PUBLISHED_FROM,
                        BlockElement::LABEL => trans('narsil::validation.attributes.published_from'),
                        BlockElement::RELATION_ELEMENT => [
                            Field::TYPE => DatetimeField::class,
                            Field::SETTINGS => app(DatetimeField::class),
                        ],
                    ],
                    [
                        BlockElement::CLASS_NAME => 'flex-row justify-between',
                        BlockElement::HANDLE => Entity::PUBLISHED_TO,
                        BlockElement::LABEL => trans('narsil::validation.attributes.published_to'),
                        BlockElement::RELATION_ELEMENT => [
                            Field::TYPE => DatetimeField::class,
                            Field::SETTINGS => app(DatetimeField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
