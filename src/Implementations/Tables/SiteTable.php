<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Sites\Site;
use Narsil\Support\TableColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Site::TABLE);
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
                id: Site::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Site::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Site::DOMAIN,
                visibility: true,
            ),
            new TableColumn(
                id: Site::PATTERN,
                visibility: true,
            ),
            new TableColumn(
                id: Site::CREATED_AT,
                visibility: false,
            ),
            new TableColumn(
                id: Site::UPDATED_AT,
                visibility: false,
            ),
        ];
    }

    #endregion
}
