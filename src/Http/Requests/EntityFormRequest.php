<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\EntityFormRequest as Contract;

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
    public function rules(): array
    {
        return [];
    }

    #endregion
}
