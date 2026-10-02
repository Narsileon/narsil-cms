<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\Frontend;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

#endregion

class HeaderResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [];
    }

    #endregion
}
