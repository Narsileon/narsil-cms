<?php

namespace Narsil\Cms\Support;

#region USE

use Illuminate\Support\Fluent;
use Narsil\Base\Enums\OperatorEnum;
use Narsil\Base\Enums\PostgreTypeEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @property string $accessorKey The accessor key of the column.
 * @property string $header The header of the column.
 * @property string $id The id of the column.
 * @property string $type The type of the column.
 * @property boolean $visibility The visibility of the column.
 */
class TableColumn extends Fluent
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     * @param boolean $visibility
     * @param string|null $accessorKey
     * @param boolean $enableColumnFilter
     * @param string|null $header
     * @param string|null $type
     *
     * @return void
     */
    public function __construct(
        string $id,
        bool $visibility,
        ?string $accessorKey = null,
        ?bool $enableColumnFilter = true,
        ?string $header = null,
        ?string $type = null,
    )
    {
        $this->set('accessorKey', $accessorKey);
        $this->set('enableColumnFilter', $enableColumnFilter);
        $this->set('header', $header);
        $this->set('id', $id);
        $this->set('type', $type);
        $this->set('visibility', $visibility);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the type of the input.
     *
     * @param string $type The type of the column.
     *
     * @return string
     */
    public static function getInputType(string $type): string
    {
        $field = null;

        switch ($type)
        {
            case PostgreTypeEnum::BIGINT->value:
            case PostgreTypeEnum::DECIMAL->value:
            case PostgreTypeEnum::DOUBLE->value:
            case PostgreTypeEnum::FLOAT->value:
            case PostgreTypeEnum::FLOAT4->value:
            case PostgreTypeEnum::FLOAT8->value:
            case PostgreTypeEnum::INT2->value:
            case PostgreTypeEnum::INT4->value:
            case PostgreTypeEnum::INT8->value:
            case PostgreTypeEnum::INTEGER->value:
            case PostgreTypeEnum::NUMERIC->value:
            case PostgreTypeEnum::SMALLINT->value:
                $field = 'number';
                break;
            case PostgreTypeEnum::DATE->value:
                $field = 'date';
                break;
            case PostgreTypeEnum::DATETIME->value:
            case PostgreTypeEnum::TIMESTAMP->value:
                $field = 'datetime-local';
                break;
            case PostgreTypeEnum::TIME->value:
                $field = 'time';
                break;
            case PostgreTypeEnum::STRING->value:
            case PostgreTypeEnum::TEXT->value:
            case PostgreTypeEnum::VARCHAR->value:
            case PostgreTypeEnum::UUID->value:
            default:
                $field = 'text';
                break;
        };

        return $field;
    }

    /**
     * Get the operators of the column.
     *
     * @param string $type The type of the column.
     *
     * @return array
     */
    public static function getOperators(string $type): array
    {
        $operators = [];

        switch ($type)
        {
            case PostgreTypeEnum::BOOLEAN->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                ];
                break;
            case PostgreTypeEnum::DATE->value:
            case PostgreTypeEnum::DATETIME->value:
            case PostgreTypeEnum::TIMESTAMP->value:
            case PostgreTypeEnum::TIME->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                    OperatorEnum::option(OperatorEnum::BEFORE),
                    OperatorEnum::option(OperatorEnum::BEFORE_OR_EQUAL),
                    OperatorEnum::option(OperatorEnum::AFTER),
                    OperatorEnum::option(OperatorEnum::AFTER_OR_EQUAL),
                ];
                break;
            case PostgreTypeEnum::INTEGER->value:
            case PostgreTypeEnum::BIGINT->value:
            case PostgreTypeEnum::SMALLINT->value:
            case PostgreTypeEnum::DECIMAL->value:
            case PostgreTypeEnum::FLOAT->value:
            case PostgreTypeEnum::DOUBLE->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                    OperatorEnum::option(OperatorEnum::GREATER_THAN),
                    OperatorEnum::option(OperatorEnum::GREATER_THAN_OR_EQUAL),
                    OperatorEnum::option(OperatorEnum::LESS_THAN),
                    OperatorEnum::option(OperatorEnum::LESS_THAN_OR_EQUAL),

                ];
                break;
            case PostgreTypeEnum::STRING->value:
            case PostgreTypeEnum::TEXT->value:
            case PostgreTypeEnum::VARCHAR->value:
            case PostgreTypeEnum::UUID->value:
            default:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                    OperatorEnum::option(OperatorEnum::CONTAINS),
                    OperatorEnum::option(OperatorEnum::NOT_CONTAINS),
                    OperatorEnum::option(OperatorEnum::STARTS_WITH),
                    OperatorEnum::option(OperatorEnum::ENDS_WITH),
                    OperatorEnum::option(OperatorEnum::DOESNT_START_WITH),
                    OperatorEnum::option(OperatorEnum::DOESNT_END_WITH),
                ];
                break;
        };

        return $operators;
    }

    #endregion
}
