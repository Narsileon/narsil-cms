<?php

namespace Narsil\Traits;

use Illuminate\Support\Facades\Cache;
use Narsil\Support\SelectOption;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        return Cache::rememberForever(static::class . ':options', function ()
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
        });
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
