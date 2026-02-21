<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\TemplateForm as Contract;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabForm extends Form implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                elements: [
                    new FieldData(
                        id: TemplateTab::HANDLE,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: TemplateTab::LABEL,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
