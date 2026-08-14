<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Sites\Site;

#endregion

class HeaderTable extends Table
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Header::TABLE);
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
                id: Header::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Header::SLUG,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(Site::VIRTUAL_TABLE),
                id: Footer::COUNT_WEBSITES,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Header::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Header::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
