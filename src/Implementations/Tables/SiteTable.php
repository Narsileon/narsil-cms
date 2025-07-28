<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Contracts\Tables\FieldTable as Contract;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Tables\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteTable extends AbstractTable implements Contract
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
                id: SiteGroup::ID,
                visibility: true,
            ),
            new TableColumn(
                accessorKey: Site::RELATION_GROUP . '.' . SiteGroup::NAME,
                id: Site::GROUP_ID,
                visibility: true,
            ),
            new TableColumn(
                id: Site::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Site::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Site::LANGUAGE,
                visibility: true,
            ),
            new TableColumn(
                id: Site::PRIMARY,
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
