<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Cms\Contracts\Fields\DatetimeField;
use Narsil\Cms\Contracts\Forms\PermissionForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Entities\Entity;

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
                        BlockElement::LABEL => trans('narsil-cms::validation.attributes.published_from'),
                        BlockElement::RELATION_BASE => [
                            Field::TYPE => DatetimeField::class,
                            Field::SETTINGS => app(DatetimeField::class),
                        ],
                    ],
                    [
                        BlockElement::CLASS_NAME => 'flex-row justify-between',
                        BlockElement::HANDLE => Entity::PUBLISHED_TO,
                        BlockElement::LABEL => trans('narsil-cms::validation.attributes.published_to'),
                        BlockElement::RELATION_BASE => [
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
