<?php

namespace App\Support;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LabelsBag
{
    #region PROPERTIES

    /**
     * @var array<string,string>
     */
    protected array $labels = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string $key
     * @param array $replace
     *
     * @return static Returns the current object instance.
     */
    public function add(string $key, array $replace = []): static
    {
        $this->labels[$key] = trans($key, $replace);

        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->labels;
    }


    #endregion
}
