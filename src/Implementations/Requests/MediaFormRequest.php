<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Cms\Contracts\FormRequests\MediaFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;

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
