<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\FieldFormRequest as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldFormRequest implements Contract
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
            Field::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
