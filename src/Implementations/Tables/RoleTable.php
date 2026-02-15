<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\PostgreTypeEnum;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Models\Policies\Role;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TableColumn;

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
                id: Role::LABEL,
                visibility: true,
            ),
            new TableColumn(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Permission::TABLE),
                id: Role::COUNT_PERMISSIONS,
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(User::TABLE),
                id: Role::COUNT_USERS,
                type: PostgreTypeEnum::INTEGER->value,
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
