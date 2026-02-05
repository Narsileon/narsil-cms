<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Validation\FormRule;

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
            Role::NAME => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Role::class,
                    Role::NAME,
                )->ignore($this?->{Role::ID}),
            ],
            Role::LABEL => [
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
