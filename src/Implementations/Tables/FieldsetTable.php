<?php

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Cms\Enums\DataTypeEnum;
use Narsil\Cms\Implementations\AbstractTable;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\TableColumn;

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
                id: Fieldset::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: Fieldset::LABEL,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(Input::TABLE),
                id: Fieldset::COUNT_FIELDSETS,
                type: DataTypeEnum::INTEGER->value,
                visibility: false,
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
