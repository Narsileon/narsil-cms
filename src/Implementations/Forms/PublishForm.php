<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Contracts\Forms\PublishForm as Contract;
use Narsil\Cms\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PublishForm extends Form implements Contract
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
                        className: 'flex-row justify-between',
                        id: Entity::PUBLISHED_FROM,
                        input: new DatetimeInputData(),
                    ),
                    new FieldData(
                        className: 'flex-row justify-between',
                        id: Entity::PUBLISHED_TO,
                        input: new DatetimeInputData(),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
