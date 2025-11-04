<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Policies\Permission;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Permission::TABLE);
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
                id: Permission::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Permission::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Permission::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Permission::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Permission::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
