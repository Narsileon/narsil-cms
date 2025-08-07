<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class LabelsBag
{
    #region PROPERTIES

    /**
     * @var array<string,string>
     */
    protected array $labels = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->labels;
    }

    #endregion

    #region FLUENT METHODS

    /**
     * @param string $key
     * @param array $replace
     *
     * @return static Returns the current object instance.
     */
    public function add(string $key, array $replace = []): static
    {
        $label = Str::contains($key, '::') ? explode('::', $key)[1] : $key;

        $this->labels[$label] = trans($key, $replace);

        return $this;
    }

    #endregion
}
