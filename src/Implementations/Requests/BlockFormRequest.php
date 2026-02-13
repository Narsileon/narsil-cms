<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\BlockFormRequest as Contract;
use Narsil\Cms\Models\Collections\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->block)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->block);
        }

        return Gate::allows(AbilityEnum::CREATE, Block::class);
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
