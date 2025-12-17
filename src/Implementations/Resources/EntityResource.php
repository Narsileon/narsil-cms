<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\EntityBlockResource;
use Narsil\Contracts\Resources\EntityResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Entities\Entity;

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
        return [
            Entity::ID => $this->{Entity::ID},
            Entity::SLUG => $this->{Entity::SLUG},
            Entity::UUID => $this->{Entity::UUID},

            Entity::ATTRIBUTE_TYPE => $this->{Entity::ATTRIBUTE_TYPE},

            Entity::RELATION_BLOCKS => $this->getBlocks(),
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
            $blocks[] = app(EntityBlockResource::class, [
                'resource' => $block,
            ]);
        }

        return $blocks;
    }

    #endregion
}
