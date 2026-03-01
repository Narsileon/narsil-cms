<?php

namespace Narsil\Cms\Http\Data\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\ConditionData;
use Narsil\Base\Http\Data\Forms\FieldsetData as BaseFieldsetData;
use Narsil\Cms\Http\Data\Forms\FieldData;
use Narsil\Cms\Models\AbstractCondition;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property boolean $collapsible
 * @property boolean $virtual
 */
class FieldsetData extends BaseFieldsetData
{
    #region PUBLIC METHODS

    /**
     * Get the fieldset data of a block.
     *
     * @param Block $block
     *
     * @return FieldsetData
     */
    public static function fromBlock(Block $block): FieldsetData
    {
        return new FieldsetData(
            description: $block->{Block::DESCRIPTION},
            id: $block->{Block::HANDLE},
            label: $block->{Block::LABEL},
            elements: $block->{Block::RELATION_ELEMENTS}->map(function ($element)
            {
                if ($element->{BlockElement::BASE_TYPE} === Field::TABLE)
                {
                    return FieldData::fromElement($element);
                }
                else
                {
                    return FieldsetData::fromElement($element);
                }
            })->toArray(),
        )->block_id($block->{Block::ID});
    }

    /**
     * Get the fieldset data of an element.
     *
     * @param Element $element
     *
     * @return FieldsetData
     */
    public static function fromElement(Element $element): FieldsetData
    {
        $base = $element->{Element::RELATION_BASE};

        return new FieldsetData(
            description: $element->{Element::DESCRIPTION} ?? $base->{Block::DESCRIPTION},
            id: $element->{Element::HANDLE} ?? $base->{Block::HANDLE},
            label: $element->{Element::LABEL} ?? $base->{Block::LABEL},
            conditions: $element->{Element::RELATION_CONDITIONS}->map(function ($condition)
            {
                return new ConditionData(
                    handle: $condition->{AbstractCondition::HANDLE},
                    operator: $condition->{AbstractCondition::OPERATOR},
                    value: $condition->{AbstractCondition::VALUE},
                );
            })->toArray(),
            elements: $base->{Block::RELATION_ELEMENTS}->map(function ($element)
            {
                if ($element->{BlockElement::BASE_TYPE} === Field::TABLE)
                {
                    return FieldData::fromElement($element);
                }
                else
                {
                    return FieldsetData::fromElement($element);
                }
            })->toArray(),
        );
    }


    #endregion
}
