<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

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
            NumberColumn::make(
                id: Host::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Host::HOSTNAME,
                visibility: true,
            ),
            TextColumn::make(
                id: Host::LABEL,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(HostLocale::TABLE),
                id: Host::COUNT_LOCALES,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(HostLocaleLanguage::TABLE),
                id: Host::COUNT_LANGUAGES,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Host::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Host::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
