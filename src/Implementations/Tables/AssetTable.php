<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Services\RouteService;
use Narsil\Cms\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AssetTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Asset::TABLE);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return RouteService::getNames($this->name, [
            'disk' => request('disk'),
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
                id: Asset::UUID,
                visibility: true,
            ),
            new TableColumn(
                id: Asset::PATH,
                visibility: true,
            ),
            new TableColumn(
                id: Asset::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Asset::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
