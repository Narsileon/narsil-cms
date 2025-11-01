<?php

#region USE

use Narsil\Enums\Database\OperatorEnum;

#endregion

return [
    OperatorEnum::AFTER_OR_EQUAL->value => 'Après ou égal',
    OperatorEnum::AFTER->value => 'Après',
    OperatorEnum::BEFORE_OR_EQUAL->value => 'Avant ou égal',
    OperatorEnum::BEFORE->value => 'Avant',
    OperatorEnum::CONTAINS->value => 'Contient',
    OperatorEnum::DOESNT_END_WITH->value => 'Ne se termine pas par',
    OperatorEnum::DOESNT_START_WITH->value => 'Ne commence pas par',
    OperatorEnum::ENDS_WITH->value => 'Se termine par',
    OperatorEnum::EQUALS->value => 'Égal à',
    OperatorEnum::GREATER_THAN_OR_EQUAL->value => 'Supérieur ou égal à',
    OperatorEnum::GREATER_THAN->value => 'Supérieur à',
    OperatorEnum::LESS_THAN_OR_EQUAL->value => 'Inférieur ou égal à',
    OperatorEnum::LESS_THAN->value => 'Inférieur à',
    OperatorEnum::NOT_CONTAINS->value => 'Ne contient pas',
    OperatorEnum::NOT_EQUALS->value => 'Différent de',
    OperatorEnum::STARTS_WITH->value => 'Commence par',
];
