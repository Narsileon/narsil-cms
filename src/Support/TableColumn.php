<?php

namespace Narsil\Support;

#region USE

use Narsil\Contracts\Fields\DateInput;
use Narsil\Contracts\Fields\NumberInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Fields\TimeInput;
use Narsil\Enums\Database\OperatorEnum;
use Narsil\Enums\Database\TypeNameEnum;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
            case TypeNameEnum::DATE->value:
            case TypeNameEnum::DATETIME->value:
            case TypeNameEnum::TIMESTAMP->value:
                $field = new Field([
                    Field::TYPE => DateInput::class,
                    Field::SETTINGS => app(DateInput::class),
                ]);
                break;
            case TypeNameEnum::TIME->value:
                $field = new Field([
                    Field::TYPE => TimeInput::class,
                    Field::SETTINGS => app(TimeInput::class),
                ]);
                break;
            case TypeNameEnum::INTEGER->value:
            case TypeNameEnum::BIGINT->value:
            case TypeNameEnum::SMALLINT->value:
            case TypeNameEnum::DECIMAL->value:
            case TypeNameEnum::FLOAT->value:
            case TypeNameEnum::DOUBLE->value:
                $field = new Field([
                    Field::TYPE => NumberInput::class,
                    Field::SETTINGS => app(NumberInput::class),
                ]);
                break;
            case TypeNameEnum::STRING->value:
            case TypeNameEnum::TEXT->value:
            case TypeNameEnum::VARCHAR->value:
            case TypeNameEnum::UUID->value:
            default:
                $field = new Field([
                    Field::TYPE => TextInput::class,
                    Field::SETTINGS => app(TextInput::class),
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
            case TypeNameEnum::BOOLEAN->value:
                $operators = [
                    OperatorEnum::EQUALS->value,
                    OperatorEnum::NOT_EQUALS->value,
                ];
                break;
            case TypeNameEnum::DATE->value:
            case TypeNameEnum::DATETIME->value:
            case TypeNameEnum::TIMESTAMP->value:
            case TypeNameEnum::TIME->value:
                $operators = [
                    OperatorEnum::EQUALS->value,
                    OperatorEnum::NOT_EQUALS->value,
                    OperatorEnum::BEFORE->value,
                    OperatorEnum::BEFORE_OR_EQUAL->value,
                    OperatorEnum::AFTER->value,
                    OperatorEnum::AFTER_OR_EQUAL->value,
                ];
                break;
            case TypeNameEnum::INTEGER->value:
            case TypeNameEnum::BIGINT->value:
            case TypeNameEnum::SMALLINT->value:
            case TypeNameEnum::DECIMAL->value:
            case TypeNameEnum::FLOAT->value:
            case TypeNameEnum::DOUBLE->value:
                $operators = [
                    OperatorEnum::EQUALS->value,
                    OperatorEnum::NOT_EQUALS->value,
                    OperatorEnum::GREATER_THAN->value,
                    OperatorEnum::GREATER_THAN_OR_EQUAL->value,
                    OperatorEnum::LESS_THAN->value,
                    OperatorEnum::LESS_THAN_OR_EQUAL->value,

                ];
                break;
            case TypeNameEnum::STRING->value:
            case TypeNameEnum::TEXT->value:
            case TypeNameEnum::VARCHAR->value:
            case TypeNameEnum::UUID->value:
            default:
                $operators = [
                    OperatorEnum::EQUALS->value,
                    OperatorEnum::NOT_EQUALS->value,
                    OperatorEnum::CONTAINS->value,
                    OperatorEnum::NOT_CONTAINS->value,
                    OperatorEnum::STARTS_WITH->value,
                    OperatorEnum::ENDS_WITH->value,
                    OperatorEnum::DOESNT_START_WITH->value,
                    OperatorEnum::DOESNT_END_WITH->value,
                ];
                break;
        };

        return $operators;
    }

    #endregion
}
