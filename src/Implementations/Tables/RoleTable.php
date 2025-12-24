<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Role::TABLE);
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
                id: Role::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Role::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Role::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Permission::TABLE),
                id: Role::COUNT_PERMISSIONS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(User::TABLE),
                id: Role::COUNT_USERS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Role::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Role::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
