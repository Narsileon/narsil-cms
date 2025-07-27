<?php

namespace Narsil\Tables\Resources;

#region USE

use Narsil\Contracts\Tables\Resources\FieldTable as Contract;
use Narsil\Models\Fields\Field;
use Narsil\Tables\AbstractTable;
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
                header: trans('narsil-cms::ui.fields'),
                id: Field::COUNT_FIELDS,
                visibility: true,
            ),
            new TableColumn(
                header: trans('narsil-cms::ui.sets'),
                id: Field::COUNT_SETS,
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
