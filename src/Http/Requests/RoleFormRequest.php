<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Models\Policies\Role;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RoleFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Role::NAME => [
                FormRule::STRING,
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
