<?php

namespace Narsil\Cms\Http\Data\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FormStepData as BaseFormStepData;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormStepData extends BaseFormStepData
{
    #region PUBLIC METHODS

    public static function fromModel(TemplateTab $templateTab)
    {
        return new FormStepData(
            id: $templateTab->{TemplateTab::HANDLE},
            label: $templateTab->{TemplateTab::LABEL},
            elements: $templateTab->{TemplateTab::RELATION_ELEMENTS}->map(function ($element)
            {
                if ($element->{TemplateTabElement::BASE_TYPE} === Field::TABLE)
                {
                    return FieldData::fromModel($element);
                }
                else
                {
                    return FieldsetData::fromModel($element);
                }
            })->toArray(),
        );
    }

    #endregion
}
