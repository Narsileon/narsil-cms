<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\Frontend;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Models\Sites\SiteUrl;

#endregion

class SiteUrlResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->loadMissing([
            SiteUrl::RELATION_HOST_LOCALE_LANGUAGE,
        ]);

        $language = $this->resource->{SiteUrl::RELATION_HOST_LOCALE_LANGUAGE};

        return [
            HostLocaleLanguage::ATTRIBUTE_DISPLAY_LANGUAGE => $language->{HostLocaleLanguage::ATTRIBUTE_DISPLAY_LANGUAGE},
            HostLocaleLanguage::LANGUAGE => $language->{HostLocaleLanguage::LANGUAGE},
            SiteUrl::URL => $this->resource->{SiteUrl::URL},
        ];
    }

    #endregion
}
