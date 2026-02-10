<?php

namespace Narsil\Cms\Support;

#region USE

use Narsil\Cms\Contracts\Fields\DateField;
use Narsil\Cms\Contracts\Fields\NumberField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Fields\TimeField;
use Narsil\Cms\Enums\Database\OperatorEnum;
use Narsil\Cms\Enums\DataTypeEnum;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TableColumn
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     * @param boolean $visibility
     * @param string|null $accessorKey
     * @param string|null $header
     * @param string|null $type
     *
     * @return void
     */
    public function __construct(
        string $id,
        bool $visibility,
        ?string $accessorKey = null,
        ?string $header = null,
        ?string $type = null,
    )
    {
        $this->accessorKey = $accessorKey;
        $this->header = $header;
        $this->id = $id;
        $this->type = $type;
        $this->visibility = $visibility;
    }

    #endregion

    #region PROPERTIES

    /**
     * The accessor key of the column.
     *
     * @var string|null
     */
    public readonly ?string $accessorKey;

    /**
     * The header of the column.
     *
     * @var string|null
     */
    public readonly ?string $header;

    /**
     * The id of the column.
     *
     * @var string
     */
    public readonly string $id;

    /**
     * The type of the column.
     *
     * @var string|null
     */
    public readonly ?string $type;

    /**
     * The visibility of the column.
     *
     * @var boolean
     */
    public readonly bool $visibility;

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the field of the column.
     *
     * @param string $type The type of the column.
     *
     * @return Field
     */
    public static function getField(string $type): Field
    {
        $field = null;

        switch ($type)
        {
            case DataTypeEnum::BIGINT->value:
            case DataTypeEnum::DECIMAL->value:
            case DataTypeEnum::DOUBLE->value:
            case DataTypeEnum::FLOAT->value:
            case DataTypeEnum::FLOAT4->value:
            case DataTypeEnum::FLOAT8->value:
            case DataTypeEnum::INT2->value:
            case DataTypeEnum::INT4->value:
            case DataTypeEnum::INT8->value:
            case DataTypeEnum::INTEGER->value:
            case DataTypeEnum::NUMERIC->value:
            case DataTypeEnum::SMALLINT->value:
                $field = new Field([
                    Field::TYPE => NumberField::class,
                    Field::SETTINGS => app(NumberField::class),
                ]);
                break;
            case DataTypeEnum::DATE->value:
            case DataTypeEnum::DATETIME->value:
            case DataTypeEnum::TIMESTAMP->value:
                $field = new Field([
                    Field::TYPE => DateField::class,
                    Field::SETTINGS => app(DateField::class),
                ]);
                break;
            case DataTypeEnum::TIME->value:
                $field = new Field([
                    Field::TYPE => TimeField::class,
                    Field::SETTINGS => app(TimeField::class),
                ]);
                break;
            case DataTypeEnum::STRING->value:
            case DataTypeEnum::TEXT->value:
            case DataTypeEnum::VARCHAR->value:
            case DataTypeEnum::UUID->value:
            default:
                $field = new Field([
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ]);
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
            case DataTypeEnum::BOOLEAN->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                ];
                break;
            case DataTypeEnum::DATE->value:
            case DataTypeEnum::DATETIME->value:
            case DataTypeEnum::TIMESTAMP->value:
            case DataTypeEnum::TIME->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                    OperatorEnum::option(OperatorEnum::BEFORE),
                    OperatorEnum::option(OperatorEnum::BEFORE_OR_EQUAL),
                    OperatorEnum::option(OperatorEnum::AFTER),
                    OperatorEnum::option(OperatorEnum::AFTER_OR_EQUAL),
                ];
                break;
            case DataTypeEnum::INTEGER->value:
            case DataTypeEnum::BIGINT->value:
            case DataTypeEnum::SMALLINT->value:
            case DataTypeEnum::DECIMAL->value:
            case DataTypeEnum::FLOAT->value:
            case DataTypeEnum::DOUBLE->value:
                $operators = [
                    OperatorEnum::option(OperatorEnum::EQUALS),
                    OperatorEnum::option(OperatorEnum::NOT_EQUALS),
                    OperatorEnum::option(OperatorEnum::GREATER_THAN),
                    OperatorEnum::option(OperatorEnum::GREATER_THAN_OR_EQUAL),
                    OperatorEnum::option(OperatorEnum::LESS_THAN),
                    OperatorEnum::option(OperatorEnum::LESS_THAN_OR_EQUAL),

                ];
                break;
            case DataTypeEnum::STRING->value:
            case DataTypeEnum::TEXT->value:
            case DataTypeEnum::VARCHAR->value:
            case DataTypeEnum::UUID->value:
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
