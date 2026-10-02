<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Resources\Frontend;

#region USE

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Sites\SiteUrl;

#endregion

class FooterResource extends JsonResource
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            Footer::CITY => $this->resource->{Footer::CITY},
            Footer::COPYRIGHT => $this->resource->{Footer::COPYRIGHT},
            Footer::COUNTRY => Locale::getDisplayRegion('_' . $this->resource->{Footer::COUNTRY}, App::getLocale()),
            Footer::EMAIL => $this->resource->{Footer::EMAIL},
            Footer::LOGO => $this->resource->{Footer::LOGO},
            Footer::ORGANIZATION => $this->resource->{Footer::ORGANIZATION},
            Footer::ORGANIZATION_SCHEMA => $this->resource->{Footer::ORGANIZATION_SCHEMA},
            Footer::PHONE => $this->resource->{Footer::PHONE},
            Footer::POSTAL_CODE => $this->resource->{Footer::POSTAL_CODE},
            Footer::STREET => $this->resource->{Footer::STREET},

            Footer::RELATION_LINKS => $this->getLinks(),
            Footer::RELATION_SOCIAL_MEDIA => $this->getSocialMedia(),
        ];
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * @return array
     */
    private function getLinks(): array
    {
        return $this->resource->{Footer::RELATION_LINKS}->map(function (FooterLink $link): array
        {
            return [
                FooterLink::LABEL => $link->{FooterLink::LABEL} ?: $link->{FooterLink::RELATION_SITE_PAGE}?->{SitePage::TITLE},
                SiteUrl::URL => $link->{FooterLink::RELATION_SITE_PAGE}?->{SitePage::RELATION_URLS}->first()?->{SiteUrl::URL},
            ];
        })->all();
    }

    /**
     * @return array
     */
    private function getSocialMedia(): array
    {
        return $this->resource->{Footer::RELATION_SOCIAL_MEDIA}->map(function (FooterSocialMedium $socialMedium): array
        {
            return [
                FooterSocialMedium::ICON => $socialMedium->{FooterSocialMedium::ICON},
                FooterSocialMedium::LABEL => $socialMedium->{FooterSocialMedium::LABEL},
                FooterSocialMedium::URL => $socialMedium->{FooterSocialMedium::URL},
            ];
        })->all();
    }

    #endregion
}
