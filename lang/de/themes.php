<?php

#region USE

use App\Enums\Configuration\ThemeEnum;

#endregion

return [
    ThemeEnum::DARK->value   => 'Dunkel',
    ThemeEnum::LIGHT->value  => 'Hell',
    ThemeEnum::SYSTEM->value => 'System',
];
