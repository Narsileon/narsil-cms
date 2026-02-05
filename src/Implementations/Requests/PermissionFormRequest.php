<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\FormRequests\PermissionFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Validation\FormRule;

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
