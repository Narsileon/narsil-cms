<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\DatetimeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\NumberInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\TanStackTables\ColumnDefData;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostTable extends Table
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

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            new ColumnDefData(
                id: Host::ID,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Host::HOSTNAME,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Host::LABEL,
                type: TextInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(HostLocale::TABLE),
                id: Host::COUNT_LOCALES,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(HostLocaleLanguage::TABLE),
                id: Host::COUNT_LANGUAGES,
                type: NumberInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Host::CREATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
            new ColumnDefData(
                id: Host::UPDATED_AT,
                type: DatetimeInputData::TYPE,
                visibility: true,
            ),
        ];
    }

    #endregion
}
