<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Forms\FormInput;
use Narsil\Models\Forms\FormInputRule;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputTable extends AbstractTable
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(FormInput::TABLE);
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
                id: FormInput::ID,
                visibility: true,
            ),
            new TableColumn(
                id: FormInput::NAME,
                visibility: true,
            ),
            new TableColumn(
                id: FormInput::HANDLE,
                visibility: true,
            ),
            new TableColumn(
                id: FormInput::REQUIRED,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FormInputRule::TABLE),
                id: FormInput::COUNT_RULES,
                type: TypeNameEnum::INTEGER->value,
                visibility: true,
            ),
            new TableColumn(
                id: FormInput::CREATED_AT,
                visibility: true,
            ),
            new TableColumn(
                id: FormInput::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
