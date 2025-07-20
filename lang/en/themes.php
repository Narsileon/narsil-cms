<?php

#region USE

use App\Enums\Configuration\ThemeEnum;

#endregion

return [
    ThemeEnum::DARK->value   => 'Dark',
    ThemeEnum::LIGHT->value  => 'Light',
    ThemeEnum::SYSTEM->value => 'System',
];
