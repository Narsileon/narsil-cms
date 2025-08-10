<?php

namespace Narsil\Casts;

#region USE

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ImageCast implements CastsAttributes
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? Storage::disk('public')->url($value) : null;
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): void
    {
        if ($value instanceof UploadedFile)
        {
            if (!empty($attributes[$key]) && Storage::disk('public')->exists($attributes[$key]))
            {
                Storage::disk('public')->delete($attributes[$key]);
            }

            $value->store('avatars', 'public');
        }

        if (is_null($value) && !empty($attributes[$key]))
        {
            Storage::disk('public')->delete($attributes[$key]);
        }
    }

    #endregion
}
