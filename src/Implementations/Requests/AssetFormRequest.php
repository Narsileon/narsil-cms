<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Base\Implementations\FormRequest;
use Narsil\Cms\Contracts\Requests\AssetFormRequest as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetFormRequest extends FormRequest implements Contract
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
