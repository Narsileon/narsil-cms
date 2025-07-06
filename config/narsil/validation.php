<?php

#region USE

use App\Http\Requests\Sites\SiteGroupRequest;
use App\Http\Requests\Sites\SiteRequest;
use App\Models\Site;
use App\Models\SiteGroup;

#endregion

return [
    Site::TABLE => SiteRequest::class,
    SiteGroup::TABLE => SiteGroupRequest::class,
];
