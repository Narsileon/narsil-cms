<?php

namespace App\Contracts\Forms;

#region USE

use App\Enums\Forms\MethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Form
{
    #region PUBLIC METHODS

    /**
     * @param string $action,
     * @param MethodEnum $method,
     * @param string $submit,
     *
     * @return array
     */
    public function get(string $action, MethodEnum $method, string $submit): array;

    #endregion
}
