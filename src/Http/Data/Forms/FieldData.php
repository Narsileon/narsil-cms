<?php

namespace Narsil\Cms\Http\Data\Forms;

#region USE

use Illuminate\Support\Facades\Config;
use Narsil\Base\Http\Data\Forms\FieldData as BaseFieldData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
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

    public static function fromModel(Element $element)
    {
        $field = $element->{Element::RELATION_BASE};

        $input = Config::get('narsil.fields.' . $field->{Field::TYPE}, TextInputData::class);

        return new FieldData(
            id: $element->{Element::HANDLE} ?? $field->{Field::HANDLE},
            label: $element->{Element::LABEL} ?? $field->{Field::LABEL},
            description: $element->{Element::DESCRIPTION} ?? $field->{Field::DESCRIPTION},
            required: $element->{Element::REQUIRED},
            translatable: $element->{Element::TRANSLATABLE},
            width: $element->{Element::WIDTH},
            input: new $input()
                ->options($field->{Field::RELATION_OPTIONS}),
        );
    }

    #endregion
}
