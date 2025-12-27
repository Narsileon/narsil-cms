<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\FooterLinkResource;
use Narsil\Contracts\Resources\FooterResource as Contract;
use Narsil\Contracts\Resources\FooterSocialMediumResource;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Globals\Footer;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            Footer::ADDRESS_LINE_1 => $this->{Footer::ADDRESS_LINE_1},
            Footer::ADDRESS_LINE_2 => $this->{Footer::ADDRESS_LINE_2},
            Footer::COMPANY => $this->{Footer::COMPANY},
            Footer::EMAIL => $this->{Footer::EMAIL},
            Footer::LOGO => $this->{Footer::LOGO},
            Footer::PHONE => $this->{Footer::PHONE},

            Footer::RELATION_LINKS => $this->getLinks(),
            Footer::RELATION_SOCIAL_MEDIA => $this->getSocialMedia(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function getLinks(): array
    {
        $links = [];

        foreach ($this->{Footer::RELATION_LINKS} as $link)
        {
            $links[] = app(FooterLinkResource::class, [
                'resource' => $link,
            ]);
        }

        return $links;
    }

    /**
     * @return array
     */
    protected function getSocialMedia(): array
    {
        $socialMedia = [];

        foreach ($this->{Footer::RELATION_SOCIAL_MEDIA} as $socialMedium)
        {
            $socialMedia[] = app(FooterSocialMediumResource::class, [
                'resource' => $socialMedium,
            ]);
        }

        return $socialMedia;
    }

    #endregion
}
