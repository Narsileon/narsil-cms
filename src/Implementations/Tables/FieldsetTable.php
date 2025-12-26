<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Fieldset::TABLE);
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
                id: Fieldset::ID,
                visibility: true,
            ),
            new TableColumn(
                id: Fieldset::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: Fieldset::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Input::TABLE),
                id: Fieldset::COUNT_INPUTS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: Fieldset::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: Fieldset::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
