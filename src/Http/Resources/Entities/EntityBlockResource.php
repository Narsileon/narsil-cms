<?php

namespace Narsil\Http\Resources\Entities;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
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
            $this->{EntityBlock::RELATION_BLOCK}->{Block::HANDLE} => $this->getFields(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    protected function getFields(): array
    {
        $entityBlockResource = Config::get('narsil.resources.' . EntityBlock::class, EntityBlockResource::class);

        $fields = [];

        foreach ($this->{EntityBlock::RELATION_FIELDS} as $entityBlockField)
        {
            if ($entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::TYPE} === BuilderField::class)
            {
                $fields[$entityBlockField->{EntityBlockField::RELATION_FIELD}->{Field::HANDLE}] = $entityBlockResource::collection($entityBlockField->{EntityBlockField::RELATION_BLOCKS});
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
