<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Str;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
final class TranslationsBag
{
    #region PROPERTIES

    /**
     * @var array<string,string>
     */
    protected array $translations = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->translations;
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

        $this->translations[$translation] = trans($key, $replace);

        return $this;
    }

    #endregion

    #endregion
}
