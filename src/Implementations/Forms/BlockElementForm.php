<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\BlockElementForm as Contract;
use Narsil\Cms\Contracts\Forms\ConditionForm;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElementForm extends Form implements Contract
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
                label: trans('narsil::ui.definition'),
                elements: [
                    new FieldData(
                        id: BlockElement::HANDLE,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: BlockElement::LABEL,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: BlockElement::DESCRIPTION,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: BlockElement::REQUIRED,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                    new FieldData(
                        id: BlockElement::TRANSLATABLE,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                ],
            ),
            ...app(ConditionForm::class)->steps,
        ];
    }

    #endregion
}
