<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Host::TABLE);
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
                id: Host::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Host::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Host::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(HostLocale::TABLE),
                id: Host::COUNT_LOCALES,
                type: TypeNameEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Host::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Host::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
