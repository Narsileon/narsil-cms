<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Implementations\AbstractTable;
use Narsil\Models\Forms\Form;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Form::TABLE);
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
                id: Form::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Form::SLUG,
                visibility: true,
            ),
            new TableColumn(
                id: Form::TITLE,
                visibility: true,
            ),
            new TableColumn(
                id: Form::DESCRIPTION,
                visibility: true,
            ),
            new TableColumn(
                id: Form::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Form::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
