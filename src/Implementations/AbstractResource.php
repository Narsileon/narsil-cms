<?php

namespace Narsil\Cms\Implementations;

#region USE

use Illuminate\Http\Resources\Json\JsonResource;
use Narsil\Cms\Contracts\Resource;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AbstractResource extends JsonResource implements Resource
{
    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = false;

    #endregion
}
