<?php

namespace Narsil\Contracts;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface FormRequest
{
    #region PUBLIC METHODS

    /**
     * @param Model|null $model
     *
     * @return array<string,mixed>
     */
    public function rules(?Model $model = null): array;

    #endregion
}
