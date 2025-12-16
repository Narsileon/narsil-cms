<?php

namespace Narsil\Http\Resources\Entities;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;

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
        $entityBlockResource = Config::get('narsil.resources.' . EntityBlock::class, EntityBlockResource::class);

        return [
            Entity::RELATION_BLOCKS => $entityBlockResource::collection($this->{Entity::RELATION_BLOCKS}),
        ];
    }

    #endregion
}
