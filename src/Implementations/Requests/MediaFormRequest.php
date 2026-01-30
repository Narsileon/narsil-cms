<?php

namespace Narsil\Implementations\Requests;

#region USE

use Narsil\Contracts\FormRequests\MediaFormRequest as Contract;
use Narsil\Implementations\AbstractFormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    #endregion
}
