<?php

namespace App\Contracts\Components;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Component
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array;

    #endregion
}
