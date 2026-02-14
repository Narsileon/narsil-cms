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
                type: PostgreTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Permission::TABLE),
                id: User::COUNT_PERMISSIONS,
                type: PostgreTypeEnum::INTEGER->value,
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
