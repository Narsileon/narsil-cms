<?php

namespace Narsil\Http\Resources\Entities;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityResource extends JsonResource
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Entity::RELATION_BLOCKS => EntityBlockResource::collection($this->{Entity::RELATION_BLOCKS}),
        ];
    }

    #endregion
}
