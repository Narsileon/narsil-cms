<?php

#region USE

use Narsil\Enums\ValidationRuleEnum;

#endregion

return [
    ValidationRuleEnum::ALPHA_DASH->value => 'Alphanumerisch mit Bindestrichen',
    ValidationRuleEnum::ARRAY->value => 'Array',
    ValidationRuleEnum::BOOLEAN->value => 'Boolesch',
    ValidationRuleEnum::CONFIRMED->value => 'Bestätigt',
    ValidationRuleEnum::DATE->value => 'Datum',
    ValidationRuleEnum::DECIMAL->value => 'Dezimal',
    ValidationRuleEnum::DISTINCT->value => 'Eindeutig',
    ValidationRuleEnum::EMAIL->value => 'E-Mail',
    ValidationRuleEnum::IMAGE->value => 'Bild',
    ValidationRuleEnum::INTEGER->value => 'Ganzzahl',
    ValidationRuleEnum::LOWERCASE->value => 'Kleinbuchstaben',
    ValidationRuleEnum::NULLABLE->value => 'Nullable',
    ValidationRuleEnum::NUMERIC->value => 'Numerisch',
    ValidationRuleEnum::SOMETIMES->value => 'Manchmal',
    ValidationRuleEnum::STRING->value => 'Zeichenkette',
    ValidationRuleEnum::URL->value => 'URL',
    ValidationRuleEnum::UUID->value => 'UUID',
];
