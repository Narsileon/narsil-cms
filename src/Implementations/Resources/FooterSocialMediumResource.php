<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\FooterSocialMediumResource as Contract;
use Narsil\Implementations\AbstractResource;
use Narsil\Models\Globals\FooterSocialMedium;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterSocialMediumResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            FooterSocialMedium::ICON => $this->{FooterSocialMedium::ICON},
            FooterSocialMedium::LABEL => $this->{FooterSocialMedium::LABEL},
            FooterSocialMedium::URL => $this->{FooterSocialMedium::URL},
        ];
    }

    #endregion
}
