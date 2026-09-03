<?php

declare(strict_types=1);

#region USE

use Narsil\Cms\Enums\SchemaEnum;

#endregion

return [
    SchemaEnum::DEFAULT->value => 'Défaut',
    SchemaEnum::LIVE->value => 'Live',
    SchemaEnum::STAGE->value => 'Stage',
    SchemaEnum::DEV->value => 'Dev',
    SchemaEnum::TEST->value => 'Test',
];
