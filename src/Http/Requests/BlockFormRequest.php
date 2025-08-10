<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\BlockFormRequest as Contract;
use Narsil\Models\Elements\Block;
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
    public function rules(?Model $model = null): array
    {
        return [
            Block::HANDLE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Block::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Block::RELATION_ELEMENTS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
