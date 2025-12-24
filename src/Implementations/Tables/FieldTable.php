<?php

namespace Narsil\Implementations\Tables;

#region USE

use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Implementations\AbstractTable;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldRule;
use Narsil\Services\ModelService;
use Narsil\Support\TableColumn;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldTable extends AbstractTable
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
                id: Field::TRANSLATABLE,
                visibility: true,
            ),
            new TableColumn(
                id: Field::REQUIRED,
                visibility: true,
            ),
            new TableColumn(
                header: ModelService::getTableLabel(FieldRule::TABLE),
                id: Field::COUNT_RULES,
                type: TypeNameEnum::INTEGER->value,
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
