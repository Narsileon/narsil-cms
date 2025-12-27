<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\FooterSocialMediumResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Globals\FooterLink;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Sites\SiteUrl;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterLinkResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            FooterLink::LABEL => $this->getLabel(),
            SiteUrl::URL => $this->{FooterLink::RELATION_SITE_PAGE}?->{SitePage::RELATION_URLS}?->first()?->{SiteUrl::URL},
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return string
     */
    protected function getLabel(): string
    {
        $label = $this->{FooterLink::LABEL};

        if (empty($label))
        {
            $label = $this->{FooterLink::RELATION_SITE_PAGE}?->{SitePage::TITLE};
        }

        return $label;
    }

    #endregion
}
