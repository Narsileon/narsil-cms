<?php

namespace Narsil\Implementations\Tables;

#region USE

use Illuminate\Support\Str;
use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormInput;
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
        $inputCountHeader = trans(('narsil::tables.' . FormInput::TABLE));

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
                header: Str::ucfirst($inputCountHeader),
                id: FormFieldset::COUNT_INPUTS,
                type: TypeNameEnum::INTEGER->value,
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
