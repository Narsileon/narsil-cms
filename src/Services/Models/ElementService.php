<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\AbstractCondition;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\BlockElementCondition;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ElementService
{
    #region PUBLIC METHODS

    /**
     * @param Model $model
     * @param array $conditions
     *
     * @return void
     */
    public static function syncConditions(Model $model, array $conditions): void
    {
        $model->conditions()->delete();

        $conditions = collect($conditions)
            ->map(function ($condition, $index)
            {
                $condition[AbstractCondition::POSITION] = $index;

                return $condition;
            })
            ->toArray();

        $model->conditions()->createMany($conditions);
    }

    #endregion
}
