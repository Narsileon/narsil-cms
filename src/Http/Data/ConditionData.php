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
     * @param AbstractCondition $condition
     *
     * @return static
     */
    public static function fromModel(AbstractCondition $condition): self
    {
        return new static(
            handle: $condition->{AbstractCondition::HANDLE},
            operator: $condition->{AbstractCondition::OPERATOR},
            value: $condition->{AbstractCondition::VALUE},
        );
    }

    #endregion
}
