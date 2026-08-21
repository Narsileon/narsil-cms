<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Cms\Models\Redirect;

#endregion

class RedirectTable extends Table
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Redirect::TABLE);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            TextColumn::make(
                id: Redirect::URL_SOURCE,
                visibility: true,
            ),
            TextColumn::make(
                id: Redirect::URL_DESTINATION,
                visibility: true,
            ),
            NumberColumn::make(
                id: Redirect::STATUS_CODE,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Redirect::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Redirect::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
