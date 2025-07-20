<?php

namespace App\Contracts\Fields\Enum;

#region USE

use App\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SwitchFieldSettings extends FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param boolean $pressed
     *
     * @return static Returns the current object instance.
     */
    public function pressed(bool $pressed): static;

    #endregion
}
