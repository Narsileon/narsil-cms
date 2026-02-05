<?php

#region USE

use Narsil\Cms\Enums\ValidationRuleEnum;

#endregion

return [
    ValidationRuleEnum::ALPHA_DASH->value => 'Alpha dash',
    ValidationRuleEnum::ARRAY->value => 'Array',
    ValidationRuleEnum::BOOLEAN->value => 'Boolean',
    ValidationRuleEnum::CONFIRMED->value => 'Confirmed',
    ValidationRuleEnum::DATE->value => 'Date',
    ValidationRuleEnum::DECIMAL->value => 'Decimal',
    ValidationRuleEnum::DISTINCT->value => 'Distinct',
    ValidationRuleEnum::EMAIL->value => 'Email',
    ValidationRuleEnum::IMAGE->value => 'Image',
    ValidationRuleEnum::INTEGER->value => 'Integer',
    ValidationRuleEnum::LOWERCASE->value => 'Lowercase',
    ValidationRuleEnum::NULLABLE->value => 'Nullable',
    ValidationRuleEnum::NUMERIC->value => 'Numeric',
    ValidationRuleEnum::SOMETIMES->value => 'Sometimes',
    ValidationRuleEnum::STRING->value => 'String',
    ValidationRuleEnum::URL->value => 'URL',
    ValidationRuleEnum::UUID->value => 'UUID',
];
