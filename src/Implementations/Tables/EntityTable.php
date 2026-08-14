<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Models\Entities\Entity;

#endregion

class EntityTable extends Table
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            NumberColumn::make(
                id: Entity::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Entity::SLUG,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Entity::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Entity::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function routes(): array
    {
        return RouteService::getNames('collections', [
            'collection' => $this->name,
        ]);
    }

    #endregion
}
