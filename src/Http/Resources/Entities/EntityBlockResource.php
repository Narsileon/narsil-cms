<?php

namespace Narsil\Http\Resources\Entities;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityBlockResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            $this->{EntityBlock::RELATION_BLOCK}->{Block::HANDLE} => array_merge($this->getFields(), $this->getBlocks()),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    protected function getBlocks()
    {
        $blocks = [];

        foreach ($this->{EntityBlock::RELATION_CHILDREN} as $entityBlock)
        {
            $blocks[$entityBlock->{EntityBlock::RELATION_BLOCK}->{Block::HANDLE}] = new EntityBlockResource($entityBlock);
        }

        return $blocks;
    }

    protected function getFields(): array
    {
        $fields = [];

        foreach ($this->{EntityBlock::RELATION_FIELDS} as $entityBlockField)
        {
            if ($entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::TYPE} === BuilderField::class)
            {
                continue;
            }
            else
            {
                $fields[$entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::HANDLE}] = $entityBlockField->{EntityBlockField::VALUE};
            }
        }

        return $fields;
    }

    #endregion
}
