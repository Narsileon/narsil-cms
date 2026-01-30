<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Storages\Media;
use Narsil\Services\RouteService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Media::TABLE);
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
                id: Media::UUID,
                visibility: true,
            ),
            new TableColumn(
                id: Media::PATH,
                visibility: true,
            ),
            new TableColumn(
                id: Media::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Media::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
