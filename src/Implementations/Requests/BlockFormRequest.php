<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\BlockFormRequest as Contract;
use Narsil\Models\Structures\Block;
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
            Block::COLLAPSIBLE => [
                FormRule::BOOLEAN,
            ],
            Block::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Block::class,
                    Block::HANDLE,
                )->ignore($model?->{Block::ID}),

            ],
            Block::NAME => [
                FormRule::REQUIRED,
            ],
            Block::VIRTUAL => [
                FormRule::BOOLEAN,
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
