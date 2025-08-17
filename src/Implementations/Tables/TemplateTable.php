<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Elements\Template;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTable extends AbstractTable
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

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function columns(): array
    {
        return [
            new TableColumn(
                id: Template::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Template::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Template::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Template::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Template::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
