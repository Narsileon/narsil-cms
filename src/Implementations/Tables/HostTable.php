<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Hosts\Host;
use Narsil\Support\TableColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
                header: trans('narsil::validation.attributes.locales'),
                id: Host::COUNT_LOCALES,
                type: TypeNameEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Host::CREATED_AT,
                visibility: false,
            ),
            new TableColumn(
                id: Host::UPDATED_AT,
                visibility: false,
            ),
        ];
    }

    #endregion
}
