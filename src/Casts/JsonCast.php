<?php

namespace Narsil\Cms\Casts;

#region USE

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class JsonCast implements CastsAttributes
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return json_decode($value ?? '{}') ?: (object)[];
    }

    /**
     * {@inheritDoc}
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (empty($value))
        {
            $value = null;
        }

        return $value ? json_encode($value) : null;
    }

    #endregion
}
