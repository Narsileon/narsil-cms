<?php

namespace Narsil\Cms\Http\Data\Forms;

#region USE

use Illuminate\Support\Facades\Config;
use Narsil\Base\Http\Data\Forms\FieldData as BaseFieldData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;

#endregionx

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldData extends BaseFieldData
{
    #region PUBLIC METHODS

    /**
     * Get the field data of an element.
     *
     * @param Element $element
     *
     * @return FieldData
     */
    public static function fromElement(Element $element): FieldData
    {
        $field = $element->{Element::RELATION_BASE};

        $input = Config::get('narsil.fields.' . $field->{Field::TYPE}, TextInputData::class);

        if ($field->{Field::TYPE} === BuilderInputData::TYPE)
        {
            $input = BuilderInputData::class;
        }

        return new FieldData(
            id: $element->{Element::HANDLE} ?? $field->{Field::HANDLE},
            label: $element->{Element::LABEL} ?? $field->{Field::LABEL},
            description: $element->{Element::DESCRIPTION} ?? $field->{Field::DESCRIPTION},
            required: $element->{Element::REQUIRED},
            translatable: $element->{Element::TRANSLATABLE},
            width: $element->{Element::WIDTH},
            input: new $input()
                ->elements($field->{Field::RELATION_BLOCKS}->map(function (Block $block)
                {
                    return FieldsetData::fromBlock($block);
                })->toArray())
                ->options($field->{Field::RELATION_OPTIONS}),
        );
    }

    #endregion
}
