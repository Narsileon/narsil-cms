<?php

namespace Narsil\Cms\Contracts;

#region USE

use Illuminate\Contracts\Validation\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface FormRequest
{
    #region PUBLIC METHODS

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,ValidationRule|array<mixed>|string>
     */
    public function rules(): array;

    #endregion
}
