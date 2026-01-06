<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\PermissionFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Policies\Permission;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->permission)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->permission);
        }

        return Gate::allows(PermissionEnum::CREATE, Permission::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Permission::LABEL => [
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
