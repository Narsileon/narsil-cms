<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\SitePageUrlResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Models\Sites\SiteUrl;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageUrlResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        $this->loadMissing([
            SiteUrl::RELATION_HOST_LOCALE_LANGUAGE,
        ]);

        $hostLocaleLanguage = $this->{SiteUrl::RELATION_HOST_LOCALE_LANGUAGE};

        return [
            HostLocaleLanguage::LANGUAGE => $hostLocaleLanguage->{HostLocaleLanguage::LANGUAGE},

            HostLocaleLanguage::ATTRIBUTE_DISPLAY_LANGUAGE => $hostLocaleLanguage->{HostLocaleLanguage::ATTRIBUTE_DISPLAY_LANGUAGE},

            SiteUrl::URL => $this->{SiteUrl::URL},
        ];
    }

    #endregion
}
