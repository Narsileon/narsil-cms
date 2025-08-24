<?php

namespace Narsil\Traits;

#region USE

use DateTimeInterface;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait HasDatetimes
{
    #region PROTECTED METHODS

    /**
     * @param DateTimeInterface $date
     *
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    #endregion
}
