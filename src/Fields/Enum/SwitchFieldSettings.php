<?php

namespace Narsil\Fields\Enum;

#region USE

use Narsil\Contracts\Fields\Enum\SwitchFieldSettings as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\FieldSettings;

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
