<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Narsil\Contracts\FormRequest as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    #endregion
}
