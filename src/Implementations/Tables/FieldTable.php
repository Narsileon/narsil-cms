<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Tables;

#region USE

use Narsil\Base\Http\Data\TanStackTables\Columns\DateTimeColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\NumberColumn;
use Narsil\Base\Http\Data\TanStackTables\Columns\TextColumn;
use Narsil\Base\Implementations\Table;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\ValidationRule;

#endregion

class FieldTable extends Table
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

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function columns(): array
    {
        return [
            NumberColumn::make(
                id: Field::ID,
                visibility: true,
            ),
            TextColumn::make(
                id: Field::HANDLE,
                visibility: true,
            ),
            TextColumn::make(
                id: Field::LABEL,
                visibility: true,
            ),
            TextColumn::make(
                id: Field::DESCRIPTION,
            ),
            TextColumn::make(
                id: Field::PLACEHOLDER,
            ),
            NumberColumn::make(
                enableColumnFilter: false,
                header: ModelService::getTableLabel(ValidationRule::TABLE),
                id: Field::COUNT_VALIDATION_RULES,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Field::CREATED_AT,
                visibility: true,
            ),
            DateTimeColumn::make(
                id: Field::UPDATED_AT,
                visibility: true,
            ),
        ];
    }

    #endregion
}
