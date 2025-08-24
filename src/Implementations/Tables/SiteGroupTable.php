<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Support\TableColumn;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteGroupTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(SiteGroup::TABLE);
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
                id: SiteGroup::ID,
                visibility: true,
            ),
            new TableColumn(
                id: SiteGroup::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: SiteGroup::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: SiteGroup::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
