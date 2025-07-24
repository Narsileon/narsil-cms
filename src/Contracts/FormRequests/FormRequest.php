<?php

namespace Narsil\Contracts\FormRequests;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface FormRequest
{
    #region PUBLIC METHODS

    /**
     * @return array<string,mixed>
     */
    public function rules(): array;

    #endregion
}
