<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\InputFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Forms\Input;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->input)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->input);
        }

        return Gate::allows(PermissionEnum::CREATE, Input::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Input::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Input::class,
                    Input::HANDLE,
                )->ignore($this->input?->{Input::ID}),
            ],
            Input::LABEL => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Input::DESCRIPTION => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Input::PLACEHOLDER => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Input::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Input::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Input::RELATION_OPTIONS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Input::RELATION_VALIDATION_RULES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
