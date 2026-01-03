<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\FieldsetFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Forms\Fieldset;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->fieldset)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->fieldset);
        }

        return Gate::allows(PermissionEnum::CREATE, Fieldset::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Fieldset::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Fieldset::class,
                    Fieldset::HANDLE,
                )->ignore($this->fieldset?->{Fieldset::ID}),

            ],
            Fieldset::NAME => [
                FormRule::REQUIRED,
            ],

            Fieldset::RELATION_ELEMENTS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
