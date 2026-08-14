<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

class TemplateTable extends Table
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Template::TABLE);
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
                id: Template::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Template::TABLE_NAME,
                visibility: true,
            ),
            TextColumn::make(
                id: Template::SINGULAR,
                visibility: true,
            ),
            TextColumn::make(
                id: Template::PLURAL,
                visibility: true,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(TemplateTab::TABLE),
                id: Template::COUNT_TABS,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Template::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Template::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
