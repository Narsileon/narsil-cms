<?php

namespace Narsil\Cms\Support;

#region USE

use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class TranslationsBag
{
    #region PROPERTIES

    /**
     * @var array<string,array{key:string,replace:array}>
     */
    protected array $data = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array
    {
        $translations = [];

        foreach ($this->data as $translation => $data)
        {
            $translations[$translation] = trans($data['key'], $data['replace']);
        }

        return $translations;
    }

    #region • FLUENT METHODS

    /**
     * @param string $key
     * @param array $replace
     *
     * @return static
     */
    public function add(string $key, array $replace = []): static
    {
        $translation = Str::contains($key, '::') ? explode('::', $key)[1] : $key;

        $this->data[$translation] = [
            'key' => $key,
            'replace' => $replace
        ];

        return $this;
    }

    #endregion

    #endregion
}
