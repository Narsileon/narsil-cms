<?php

#region USE

use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;

#endregion

return [
    Block::TABLE => [
        Block::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this block.',
        Block::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this block.',
    ],
    Field::TABLE => [
        Field::DESCRIPTION => 'The default description. The value can be overridden by templates and blocks that implement this field.',
        Field::HANDLE => 'The default handle. The value can be overridden by templates and blocks that implement this field.',
        Field::LABEL => 'The default label. The value can be overridden by templates and blocks that implement this field.',
    ],
    Host::TABLE => [
        Host::HOSTNAME => 'The hostname of the website, e.g. \'domain.com\' or \'subdomain.domain.com\'.',
        Host::LABEL => 'The display label shown in the sidebar.',
    ],
    HostLocale::TABLE => [
        HostLocale::PATTERN => 'The pattern of the URLs, e.g. \':example\'.',
    ],
];
