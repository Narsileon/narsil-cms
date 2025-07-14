<?php

namespace App\Interfaces\Components;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface IComponent
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public function get(): array;

    #endregion
}
