<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityTable extends AbstractTable
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return RouteService::getNames('collections', [
            'collection' => $this->name,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new ColumnDefData(
                id: Entity::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::SLUG,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::CREATED_AT,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Entity::UPDATED_AT,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
