<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\DataTypeEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(FormFieldset::TABLE);
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
                id: FormFieldset::ID,
                visibility: true,
            ),
            new TableColumn(
                id: FormFieldset::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: FormFieldset::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FormInput::TABLE),
                id: FormFieldset::COUNT_INPUTS,
                type: DataTypeEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: FormFieldset::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: FormFieldset::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
