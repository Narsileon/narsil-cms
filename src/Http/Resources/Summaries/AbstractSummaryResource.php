<?php

namespace Narsil\Http\Resources\Summaries;

#region USE

use Illuminate\Http\Resources\Json\JsonResource;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractSummaryResource extends JsonResource
{
    #region CONSTANTS

    /**
     * The name of the "href" property.
     *
     * @var string
     */
    final public const HREF = 'href';

    #endregion

    #region PROPERTIES

    /**
     * {@inheritDoc}
     */
    public static $wrap = false;

    #endregion
}
