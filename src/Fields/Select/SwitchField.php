<?php

namespace Narsil\Fields\Select;

#region USE

use Narsil\Contracts\Fields\Select\SwitchField as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SwitchField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            icon: 'toggle-right',
            label: trans('narsil-cms::fields.switch'),
            type: TypeEnum::SWITCH->value
        );

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
