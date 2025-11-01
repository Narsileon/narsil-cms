<?php

#region USE

use Narsil\Enums\Database\OperatorEnum;

#endregion

return [
    OperatorEnum::AFTER_OR_EQUAL->value => 'Nach oder gleich',
    OperatorEnum::AFTER->value => 'Nach',
    OperatorEnum::BEFORE_OR_EQUAL->value => 'Vor oder gleich',
    OperatorEnum::BEFORE->value => 'Vor',
    OperatorEnum::CONTAINS->value => 'Enthält',
    OperatorEnum::DOESNT_END_WITH->value => 'Endet nicht mit',
    OperatorEnum::DOESNT_START_WITH->value => 'Beginnt nicht mit',
    OperatorEnum::ENDS_WITH->value => 'Endet mit',
    OperatorEnum::EQUALS->value => 'Gleich',
    OperatorEnum::GREATER_THAN_OR_EQUAL->value => 'Größer oder gleich',
    OperatorEnum::GREATER_THAN->value => 'Größer als',
    OperatorEnum::LESS_THAN_OR_EQUAL->value => 'Kleiner oder gleich',
    OperatorEnum::LESS_THAN->value => 'Kleiner als',
    OperatorEnum::NOT_CONTAINS->value => 'Enthält nicht',
    OperatorEnum::NOT_EQUALS->value => 'Nicht gleich',
    OperatorEnum::STARTS_WITH->value => 'Beginnt mit',
];
