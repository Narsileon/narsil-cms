<?php

namespace Narsil\Cms\Implementations\Requests\Ui;

#region USE

use Narsil\Base\Models\TanStackTable;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\BlockFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TanStackTableFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            TanStackTable::COLUMN_ORDER => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::COLUMN_SIZING => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::COLUMN_VISIBILITY => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::FILTERS => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::GLOBAL_FILTER => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::NAME => [
                FormRule::STRING,
                FormRule::SOMETIMES,
            ],
            TanStackTable::PAGINATION => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::ROW_SELECTION => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::SORTING => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
            TanStackTable::TABLE_ID => [
                FormRule::STRING,
            ],
        ];
    }

    #endregion
}
