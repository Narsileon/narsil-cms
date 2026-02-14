<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\PostgreTypeEnum;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\RouteService;
use Narsil\Cms\Support\TableColumn;

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
            new TableColumn(
                id: Entity::ID,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::SLUG,
                type: PostgreTypeEnum::STRING->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::CREATED_AT,
                type: PostgreTypeEnum::STRING->value,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::UPDATED_AT,
                type: PostgreTypeEnum::STRING->value,
                visibility: true,
            ),
        ];
    }

    #endregion
}
