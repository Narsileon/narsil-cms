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
            new ColumnDefData(
                id: User::ID,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                id: User::EMAIL,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: User::FIRST_NAME,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                id: User::LAST_NAME,
                type: InputTypeEnum::TEXT,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Role::TABLE),
                id: User::COUNT_ROLES,
                type: InputTypeEnum::NUMBER,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Permission::TABLE),
                id: User::COUNT_PERMISSIONS,
                type: InputTypeEnum::NUMBER,
            ),
            new ColumnDefData(
                id: User::CREATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
            new ColumnDefData(
                id: User::UPDATED_AT,
                type: InputTypeEnum::DATETIME,
                visibility: true,
            ),
        ];
    }

    #endregion
}
