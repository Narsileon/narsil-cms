<?php

namespace App\Interfaces\Forms;

#region USE

use App\Enums\Forms\MethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface IForm
{
    #region PUBLIC METHODS

    /**
     * @var string
     */
    public function get(string $action, MethodEnum $method, string $submit): array;

    #endregion
}
