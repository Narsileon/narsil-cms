<?php

namespace Narsil\Cms\Support\Models;

#region USE

use Illuminate\Support\Fluent;
use Narsil\Cms\Models\AbstractCondition;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConditionData extends Fluent
{
    #region CONSTRUCTOR

    /**
     * @param string $handle
     * @param string $operator
     * @param string $value
     *
     * @return void
     */
    public function __construct(
        string $handle,
        string $operator,
        string $value,
    )
    {
        $this->set('handle', $handle);
        $this->set('operator', $operator);
        $this->set('value', $value);
    }

    #endregion

    #region PROPERTIES

    #region PUBLIC METHODS

    /**
     * @param AbstractCondition $model
     *
     * @return static
     */
    public static function fromModel(AbstractCondition $model): self
    {
        return new static(
            handle: $model->{AbstractCondition::HANDLE},
            operator: $model->{AbstractCondition::OPERATOR},
            value: $model->{AbstractCondition::VALUE},
        );
    }

    #endregion
}
