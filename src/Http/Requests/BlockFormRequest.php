<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\BlockFormRequest as Contract;
use Narsil\Models\Elements\Block;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
            Block::COLLAPSIBLE => [
                FormRule::BOOLEAN,
            ],
            Block::HANDLE => [
                ...FormRule::getSlugRules(),
                FormRule::REQUIRED,
                FormRule::unique(
                    Block::class,
                    Block::HANDLE,
                )->ignore($model?->{Block::ID}),

            ],
            Block::NAME => [
                FormRule::REQUIRED,
            ],

            Block::RELATION_ELEMENTS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Block::RELATION_SETS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
