<?php

namespace Narsil\Cms\Contracts;

#region USE

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Resource
{
    #region PUBLIC METHODS

    /**
     * Transform the resource into an array.
     *
     * @param Request  $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray(Request $request);

    #endregion
}
