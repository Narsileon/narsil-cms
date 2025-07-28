<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Contracts\Tables\FieldTable as Contract;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Fields\Field;
use Narsil\Tables\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldTable extends AbstractTable implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Field::TABLE);
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
                id: Field::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Field::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Field::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Field::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Field::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
