<?php

namespace Narsil\Http\Requests\Resources;

#region USE

use Narsil\Contracts\FormRequests\Resources\FieldFormRequest as Contract;
use Narsil\Models\Fields\Field;
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
            Field::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
