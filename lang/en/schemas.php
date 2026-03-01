<?php

#region USE

use Narsil\Cms\Enums\SchemaEnum;

#endregion

return [
    SchemaEnum::DEFAULT->value => 'Default',
    SchemaEnum::DEV->value => 'Dev',
    SchemaEnum::LIVE->value => 'Live',
    SchemaEnum::STAGE->value => 'Stage',
    SchemaEnum::TEST->value => 'Test',
];
