<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Contracts\Tables\FieldSetTable as Contract;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Fields\FieldSet;
use Narsil\Tables\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldSetTable extends AbstractTable implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(FieldSet::TABLE);
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
                id: FieldSet::ID,
                visibility: true,
            ),
            new TableColumn(
                id: FieldSet::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: FieldSet::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: trans('narsil-cms::ui.fields'),
                id: FieldSet::COUNT_FIELDS,
                visibility: true,
            ),
            new TableColumn(
                header: trans('narsil-cms::ui.sets'),
                id: FieldSet::COUNT_FIELD_SETS,
                visibility: true,
            ),
            new TableColumn(
                id: FieldSet::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: FieldSet::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
