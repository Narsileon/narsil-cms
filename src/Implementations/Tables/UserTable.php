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
class UserTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(User::TABLE);
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
                id: User::ID,
                visibility: true,
            ),
            new TableColumn(
                id: User::EMAIL,
                visibility: true,
            ),
            new TableColumn(
                id: User::FIRST_NAME,
                visibility: true,
            ),
            new TableColumn(
                id: User::LAST_NAME,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Role::TABLE),
                id: User::COUNT_ROLES,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Permission::TABLE),
                id: User::COUNT_PERMISSIONS,
                type: DataTypeEnum::INTEGER->value,
                visibility: false,
            ),
            new TableColumn(
                id: User::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: User::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
