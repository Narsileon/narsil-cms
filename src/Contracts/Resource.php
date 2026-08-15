<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts;

#region USE

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

#endregion

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
