<?php

namespace Narsil\Traits;

#region USE

use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait Enumerable
{
    #region PUBLIC METHODS

    /**
     * Get the enum as select options.
     *
     * @return array<SelectOption>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case)
        {
            $options[] = new SelectOption(
                label: $case->value,
                value: $case->value,
            );
        }

        return $options;
    }

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
