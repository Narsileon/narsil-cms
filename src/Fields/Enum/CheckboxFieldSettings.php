<?php

namespace Narsil\Fields\Enum;

#region USE

use Narsil\Contracts\Fields\Enum\CheckboxFieldSettings as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\FieldSettings;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CheckboxFieldSettings extends FieldSettings implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(TypeEnum::CHECKBOX->value);

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
    final public function checked(bool $checked): static
    {
        $this->settings[PropEnum::CHECKED->value] = $checked;

        return $this;
    }

    #endregion
}
