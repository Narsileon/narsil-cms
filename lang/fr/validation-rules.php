<?php

#region USE

use Narsil\Cms\Enums\ValidationRuleEnum;

#endregion

return [
    ValidationRuleEnum::ALPHA_DASH->value => 'Alphanumérique avec tirets',
    ValidationRuleEnum::ARRAY->value => 'Tableau',
    ValidationRuleEnum::BOOLEAN->value => 'Booléen',
    ValidationRuleEnum::CONFIRMED->value => 'Confirmé',
    ValidationRuleEnum::DATE->value => 'Date',
    ValidationRuleEnum::DECIMAL->value => 'Décimal',
    ValidationRuleEnum::DISTINCT->value => 'Distinct',
    ValidationRuleEnum::EMAIL->value => 'E-mail',
    ValidationRuleEnum::IMAGE->value => 'Image',
    ValidationRuleEnum::INTEGER->value => 'Entier',
    ValidationRuleEnum::LOWERCASE->value => 'Minuscules',
    ValidationRuleEnum::NULLABLE->value => 'Nullable',
    ValidationRuleEnum::NUMERIC->value => 'Numérique',
    ValidationRuleEnum::SOMETIMES->value => 'Parfois',
    ValidationRuleEnum::STRING->value => 'Chaîne de caractères',
    ValidationRuleEnum::URL->value => 'URL',
    ValidationRuleEnum::UUID->value => 'UUID',
];
