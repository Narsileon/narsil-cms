<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\BlockFormRequest as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockFormRequest implements Contract
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
