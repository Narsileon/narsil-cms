<?php

#region USE

use App\Enums\Configuration\ThemeEnum;

#endregion

return [
    ThemeEnum::DARK->value   => 'Sombre',
    ThemeEnum::LIGHT->value  => 'Clair',
    ThemeEnum::SYSTEM->value => 'Système',
];
