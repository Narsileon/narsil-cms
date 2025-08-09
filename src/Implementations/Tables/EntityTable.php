<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Contracts\Tables\EntityTable as Contract;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Entities\Entity;
use Narsil\Services\RouteService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityTable extends AbstractTable implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param string $type
     *
     * @return void
     */
    public function __construct(string $type = "")
    {
        $this->type = $type;

        parent::__construct(Entity::TABLE);
    }

    #endregion

    #region PROPERTIES

    protected readonly string $type;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return RouteService::getNames($this->name, [
            'type' => $this->type,
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
                visibility: true,
            ),
            new TableColumn(
                id: Entity::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Entity::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
