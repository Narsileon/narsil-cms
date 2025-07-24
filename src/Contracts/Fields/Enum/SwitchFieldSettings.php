<?php

namespace Narsil\Contracts\Fields\Enum;

#region USE

use Narsil\Contracts\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface SwitchFieldSettings extends FieldSettings
{
    #region PUBLIC METHODS

    /**
     * @param boolean $checked
     *
     * @return static Returns the current object instance.
     */
    public function checked(bool $checked): static;

    #endregion
}
