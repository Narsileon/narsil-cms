<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Globals\Footer;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Footer::TABLE);
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
                id: Footer::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Footer::CREATED_AT,
                visibility: false,
            ),
            new TableColumn(
                id: Footer::UPDATED_AT,
                visibility: false,
            ),
        ];
    }

    #endregion
}
