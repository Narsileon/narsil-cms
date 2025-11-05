<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Globals\Header;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderTable extends AbstractTable
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

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Header::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Header::CREATED_AT,
                visibility: false,
            ),
            new TableColumn(
                id: Header::UPDATED_AT,
                visibility: false,
            ),
        ];
    }

    #endregion
}
