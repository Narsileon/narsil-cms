<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Models\Policies\Role;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
            Role::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Role::class,
                    Role::HANDLE,
                )->ignore($model?->{Role::ID}),
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
