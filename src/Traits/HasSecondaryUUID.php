<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasSecondaryUUID
{
    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #endregion

    #region PROTECTED METHODS

    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasSecondaryUUID(): void
    {
        static::creating(function (Model $model)
        {
            if (empty($model->{self::UUID}))
            {
                $model->{self::UUID} = Str::uuid7();
            }
        });
    }

    #endregion
}
