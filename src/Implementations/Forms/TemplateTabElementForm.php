<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\ConditionForm;
use Narsil\Cms\Contracts\Forms\TemplateTabElementForm as Contract;
use Narsil\Cms\Http\Data\Forms\FieldData;
use Narsil\Cms\Http\Data\Forms\FormStepData;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabElementForm extends Form implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil-ui::ui.definition'),
                elements: [
                    new FieldData(
                        id: TemplateTabElement::HANDLE,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: TemplateTabElement::LABEL,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: TemplateTabElement::DESCRIPTION,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: TemplateTabElement::REQUIRED,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                    new FieldData(
                        id: TemplateTabElement::TRANSLATABLE,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                ],
            ),
            ...app(ConditionForm::class)->tabs,
        ];
    }

    #endregion
}
