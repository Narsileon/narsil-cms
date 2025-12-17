<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Resources\EntityResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityBlock;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        $entityBlockResource = Config::get('narsil.resources.' . EntityBlock::class, EntityBlockResource::class);

        return [
            Entity::ID => $this->{Entity::ID},
            Entity::SLUG => $this->{Entity::SLUG},
            Entity::UUID => $this->{Entity::UUID},

            Entity::ATTRIBUTE_TYPE => $this->{Entity::ATTRIBUTE_TYPE},

            Entity::RELATION_BLOCKS => $entityBlockResource::collection($this->{Entity::RELATION_BLOCKS}),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the blocks.
     * 
     * @return array
     */
    protected function getBlocks(): array
    {
        $blocks = [];

        foreach ($this->{Entity::RELATION_BLOCKS} as $block)
        {
            $blocks[] = app(Entityblock::class, [
                'resource' => $block,
            ]);
        }

        return $blocks;
    }

    #endregion
}
