<?php

namespace Narsil\Http\Data;

#region USE

use Narsil\Models\AbstractCondition;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#endregion

#[TypeScript]
class ConditionData extends Data
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
        public string $handle,
        public string $operator,
        public string $value,
    )
    {
        //
    }

    #endregion

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
