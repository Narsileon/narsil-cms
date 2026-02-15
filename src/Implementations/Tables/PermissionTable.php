<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Models\Policies\Role;
use Narsil\Base\Models\User;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Implementations\AbstractTable;

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
            new ColumnDefData(
                id: Permission::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: Permission::NAME,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: Permission::LABEL,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Role::TABLE),
                id: Permission::COUNT_ROLES,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(User::TABLE),
                id: Permission::COUNT_USERS,
                type: InputTypeEnum::NUMBER,
            ),
            new ColumnDefData(
                id: Permission::CREATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
            new ColumnDefData(
                id: Permission::UPDATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
        ];
    }

    #endregion
}
