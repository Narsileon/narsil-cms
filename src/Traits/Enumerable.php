<?php

namespace Narsil\Traits;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
trait Enumerable
{
    #region PUBLIC METHODS

    /**
     * Get the values of the enum.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(function ($case)
        {
            return $case->value;
        }, self::cases());
    }

    #endregion
}
