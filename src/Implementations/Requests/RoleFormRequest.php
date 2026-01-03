<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Models\Policies\Role;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->role)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->role);
        }

        return Gate::allows(PermissionEnum::CREATE, Role::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Role::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Role::class,
                    Role::HANDLE,
                )->ignore($this?->{Role::ID}),
            ],
            Role::NAME => [
                FormRule::REQUIRED,
            ],

            Role::RELATION_PERMISSIONS => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
