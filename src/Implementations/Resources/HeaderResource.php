<?php

namespace Narsil\Implementations\Resources;

#region USE

use Illuminate\Http\Request;
use Narsil\Contracts\Resources\HeaderResource as Contract;
use Narsil\Implementations\AbstractResource;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderResource extends AbstractResource implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function toArray(Request $request): array
    {
        return [
            //
        ];
    }

    #endregion
}
