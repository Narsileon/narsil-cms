<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Resources\EntityBlockResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Entities\EntityBlock;
use Narsil\Models\Entities\EntityBlockField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityBlockResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Block::HANDLE => $this->{EntityBlock::RELATION_BLOCK}->{Block::HANDLE},

            ...$this->getFields(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function getFields(): array
    {
        $fields = [];

        foreach ($this->{EntityBlock::RELATION_FIELDS} as $entityBlockField)
        {
            if ($entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::TYPE} === BuilderField::class)
            {
                $fields[$entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::HANDLE}] = $this->getFieldBlocks($entityBlockField);
            }
            else
            {
                $fields[$entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::HANDLE}] = $entityBlockField->{EntityBlockField::VALUE};
            }
        }

        return $fields;
    }

    /**
     * @param EntityBlockField $entityBlockField
     * 
     * @return array
     */
    protected function getFieldBlocks(EntityBlockField $entityBlockField): array
    {
        $blocks = [];

        foreach ($entityBlockField->{EntityBlockField::RELATION_BLOCKS} as $entityBlock)
        {
            $blocks[] = app(EntityBlockResource::class, [
                'resource' => $entityBlock,
            ]);
        }

        return $blocks;
    }

    #endregion
}
