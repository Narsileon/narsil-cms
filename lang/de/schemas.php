<?php

declare(strict_types=1);

#region USE

use Narsil\Cms\Enums\SchemaEnum;

#endregion

return [
    SchemaEnum::DEFAULT->value => 'Standard',
    SchemaEnum::DEV->value => 'Dev',
    SchemaEnum::LIVE->value => 'Live',
    SchemaEnum::STAGE->value => 'Stage',
    SchemaEnum::TEST->value => 'Test',
];
