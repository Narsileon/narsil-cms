<?php

namespace Narsil\Services;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Narsil\Enums\Database\OperatorEnum;
use Narsil\Enums\Database\TypeNameEnum;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class QueryService
{
    #region CONSTANTS

    /**
     * The name of the "column" parameter.
     *
     * @var string
     */
    final public const COLUMN = 'column';

    /**
     * The name of the "operator" parameter.
     *
     * @var string
     */
    final public const OPERATOR = 'operator';

    /**
     * The name of the "value" parameter.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param Builder $query
     * @param array $filters
     *
     * @return void
     */
    public static function applyFilters(Builder $query, array $filters): void
    {
        $locale = App::getLocale();

        $model = $query->getModel();

        foreach ($filters as $filter)
        {
            $column = Arr::get($filter, self::COLUMN);
            $operator = Arr::get($filter, self::OPERATOR);
            $value = Arr::get($filter, self::VALUE);

            if (empty($column) || empty($operator) || empty($value))
            {
                continue;
            }

            $key = $column;

            if (method_exists($model, 'isTranslatableAttribute') && $model->isTranslatableAttribute($column))
            {
                $key = "$column->$locale";
            }

            match ($operator)
            {
                OperatorEnum::AFTER_OR_EQUAL->value => $query->whereDate($key, '>=', $value),
                OperatorEnum::AFTER->value => $query->whereDate($key, '>', $value),
                OperatorEnum::BEFORE_OR_EQUAL->value => $query->whereDate($key, '<=', $value),
                OperatorEnum::BEFORE->value => $query->whereDate($key, '<', $value),
                OperatorEnum::CONTAINS->value => $query->where($key, 'LIKE', "%{$value}%"),
                OperatorEnum::DOESNT_END_WITH->value => $query->where($key, 'NOT LIKE', "%{$value}"),
                OperatorEnum::DOESNT_START_WITH->value => $query->where($key, 'NOT LIKE', "{$value}%"),
                OperatorEnum::ENDS_WITH->value => $query->where($key, 'LIKE', "%{$value}"),
                OperatorEnum::EQUALS->value => $query->where($key, '=', $value),
                OperatorEnum::GREATER_THAN_OR_EQUAL->value => $query->where($key, '>=', $value),
                OperatorEnum::GREATER_THAN->value => $query->where($key, '>', $value),
                OperatorEnum::LESS_THAN_OR_EQUAL->value => $query->where($key, '<=', $value),
                OperatorEnum::LESS_THAN->value => $query->where($key, '<', $value),
                OperatorEnum::NOT_CONTAINS->value => $query->where($key, 'NOT LIKE', "%{$value}%"),
                OperatorEnum::NOT_EQUALS->value => $query->where($key, '!=', $value),
                OperatorEnum::STARTS_WITH->value => $query->where($key, 'LIKE', "{$value}%"),
                default => null,
            };
        }
    }

    /**
     * @param Builder $query
     * @param string $table
     * @param string $search
     *
     * @return void
     */
    public static function applySearch(Builder $query, string $table, string $search): void
    {
        $columns = TableService::getColumns($table);

        $columns->each(function ($column) use ($query, $search)
        {
            switch ($column->type)
            {
                case TypeNameEnum::VARCHAR->value:
                    $query->orWhere($column->name, 'like', '%' . $search . '%');
                    break;
                default:
                    break;
            }
        });
    }

    /**
     * @param Builder $query
     * @param array $sortings
     *
     * @return void
     */
    public static function applySorting(Builder $query, array $sortings): void
    {
        foreach ($sortings as $key => $value)
        {
            $query->orderBy($key, $value);
        }
    }

    #endregion
}
