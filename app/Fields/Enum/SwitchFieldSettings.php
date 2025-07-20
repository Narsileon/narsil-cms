<?php

namespace App\Fields\Enum;

#region USE

use App\Contracts\Fields\Enum\SwitchFieldSettings as Contract;
use App\Enums\Fields\PropEnum;
use App\Enums\Fields\TypeEnum;
use App\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SwitchFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::SWITCH->value);

        $this->checked(false);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getForm(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    final public function checked(bool $value): static
    {
        $this->settings[PropEnum::CHECKED->value] = $value;

        return $this;
    }

    #endregion
}
