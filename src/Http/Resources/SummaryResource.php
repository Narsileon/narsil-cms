<?php

namespace Narsil\Http\Resources;

#region USE

use Illuminate\Http\Resources\Json\JsonResource;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SummaryResource extends JsonResource
{
    #region CONSTANTS

    /**
     * The name of the "href" property.
     *
     * @var string
     */
    final public const HREF = 'href';

    /**
     * The name of the "name" property.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = false;

    #endregion
}
