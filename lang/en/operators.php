<?php

#region USE

use Narsil\Cms\Enums\Database\OperatorEnum;

#endregion

return [
    OperatorEnum::AFTER_OR_EQUAL->value => 'After or equal',
    OperatorEnum::AFTER->value => 'After',
    OperatorEnum::BEFORE_OR_EQUAL->value => 'Before or equal',
    OperatorEnum::BEFORE->value => 'Before',
    OperatorEnum::CONTAINS->value => 'Contains',
    OperatorEnum::DOESNT_END_WITH->value => "Doesn't end with",
    OperatorEnum::DOESNT_START_WITH->value => "Doesn't start with",
    OperatorEnum::ENDS_WITH->value => 'Ends with',
    OperatorEnum::EQUALS->value => 'Equals',
    OperatorEnum::GREATER_THAN_OR_EQUAL->value => 'Greater than or equal',
    OperatorEnum::GREATER_THAN->value => 'Greater than',
    OperatorEnum::LESS_THAN_OR_EQUAL->value => 'Less than or equal',
    OperatorEnum::LESS_THAN->value => 'Less than',
    OperatorEnum::NOT_CONTAINS->value => "Doesn't contain",
    OperatorEnum::NOT_EQUALS->value => 'Not equals',
    OperatorEnum::STARTS_WITH->value => 'Starts with',
];
