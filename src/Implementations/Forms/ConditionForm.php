<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Enums\OperatorEnum;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TableInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\BlockForm as Contract;
use Narsil\Cms\Models\AbstractCondition;
use Narsil\Cms\Models\Collections\Element;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConditionForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: 'condition',
                label: trans('narsil-cms::validation.attributes.conditions'),
                elements: [
                    new FieldData(
                        id: Element::RELATION_CONDITIONS,
                        input: new TableInputData(
                            columns: [
                                new FieldData(
                                    id: AbstractCondition::HANDLE,
                                    required: true,
                                    input: new TextInputData(),
                                ),
                                new FieldData(
                                    id: AbstractCondition::OPERATOR,
                                    required: true,
                                    input: new SelectInputData(
                                        options: [
                                            OperatorEnum::option(OperatorEnum::EQUALS),
                                            OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                                            OperatorEnum::option(OperatorEnum::GREATER_THAN),
                                            OperatorEnum::option(OperatorEnum::GREATER_THAN_OR_EQUAL),
                                            OperatorEnum::option(OperatorEnum::LESS_THAN),
                                            OperatorEnum::option(OperatorEnum::LESS_THAN_OR_EQUAL),
                                        ]
                                    ),
                                ),
                                new FieldData(
                                    id: AbstractCondition::VALUE,
                                    required: true,
                                    input: new TextInputData(),
                                ),
                            ],
                        ),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
