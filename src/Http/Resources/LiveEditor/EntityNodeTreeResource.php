<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\LiveEditor;

#region USE

use Illuminate\Http\Request;
use Narsil\Base\Implementations\Resource;
use Narsil\Cms\Services\LiveEditor\EntityNodeTreeService;

#endregion

class EntityNodeTreeResource extends Resource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return app(EntityNodeTreeService::class)->build($this->resource);
    }

    #endregion
}
