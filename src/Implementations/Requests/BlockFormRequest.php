<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\BlockFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Structures\Block;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->block)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->block);
        }

        return Gate::allows(PermissionEnum::CREATE, Block::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
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
                )->ignore($this->block?->{Block::ID}),

            ],
            Block::LABEL => [
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
