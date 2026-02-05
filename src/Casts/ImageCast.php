<?php

namespace Narsil\Cms\Casts;

#region USE

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ImageCast implements CastsAttributes
{
    #region CONSTRUCTOR

    /**
     * @param string $directory
     *
     * @return void
     */
    public function __construct(string $directory = '')
    {
        $this->directory = trim($directory, '/');
    }

    #endregion

    #region PROPERTIES

    /**
     * @var string
     */
    protected readonly string $directory;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return $value ? $value : null;
    }

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        $path = Arr::get($attributes, $key);

        if (is_null($value) && $path)
        {
            $this->deleteImage($path);

            return null;
        }
        else if ($value instanceof UploadedFile)
        {
            if ($oldPath = Arr::get($attributes, $key))
            {
                $this->deleteImage($oldPath);
            }

            $contents = file_get_contents($value->getRealPath());

            $fileName = hash('sha256', $contents);
            $fileExtension = $value->getClientOriginalExtension();

            $path = "{$this->directory}/{$fileName}.{$fileExtension}";

            if (!Storage::disk('images')->exists($path))
            {
                Storage::disk('images')->put($path, $contents);
            }

            return Storage::disk('images')->url($path);
        }

        return $value;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param string $path
     *
     * @return boolean
     */
    protected function deleteImage(string $path): bool
    {
        return Storage::disk('images')
            ->delete($path);
    }

    #endregion
}
