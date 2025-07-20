<?php

namespace App\Contracts\Fields\Enum;

#region USE

use App\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface CheckboxFieldSettings extends FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param boolean $value
     *
     * @return static Returns the current object instance.
     */
    public function value(bool $value): static;

    #endregion
}
