<?php

namespace App\Interfaces\FormRequests;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface IFormRequest
{
    #region PUBLIC METHODS

    /**
     * @return array<string,mixed>
     */
    public function rules(): array;

    #endregion
}
