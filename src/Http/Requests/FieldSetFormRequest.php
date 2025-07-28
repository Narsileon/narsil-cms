<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\FieldSetFormRequest as Contract;
use Narsil\Models\Fields\Field;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Field::HANDLE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Field::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
