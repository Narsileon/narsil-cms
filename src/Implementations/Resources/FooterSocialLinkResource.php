<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\FooterSocialLinkResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Globals\FooterSocialLink;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterSocialLinkResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            FooterSocialLink::ICON => $this->{FooterSocialLink::ICON},
            FooterSocialLink::LABEL => $this->{FooterSocialLink::LABEL},
            FooterSocialLink::URL => $this->{FooterSocialLink::URL},
        ];
    }

    #endregion
}
