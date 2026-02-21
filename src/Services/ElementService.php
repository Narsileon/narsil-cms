<?php

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Models\AbstractCondition;

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
