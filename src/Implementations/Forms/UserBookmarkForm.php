<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkForm extends Form
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
                        id: UserBookmark::NAME,
                        required: true,
                        input: new TextInputData(),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
