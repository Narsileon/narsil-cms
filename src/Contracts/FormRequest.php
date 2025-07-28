<?php

namespace Narsil\Contracts;

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
