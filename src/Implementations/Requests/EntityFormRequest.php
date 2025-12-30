<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;
use Narsil\Models\Entities\Entity;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Entity::PUBLISHED_FROM => [
                FormRule::DATE,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            Entity::PUBLISHED_TO => [
                FormRule::DATE,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            Entity::SLUG => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
