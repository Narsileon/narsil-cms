<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class EntityFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [];
    }

    #endregion
}
