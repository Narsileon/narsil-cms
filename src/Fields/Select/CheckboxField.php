<?php

namespace Narsil\Fields\Select;

#region USE

use Narsil\Contracts\Fields\Select\CheckboxField as Contract;
use Narsil\Enums\Fields\PropEnum;
use Narsil\Enums\Fields\TypeEnum;
use Narsil\Fields\AbstractField;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CheckboxField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            icon: 'square-mouse-pointer',
            label: trans('narsil-cms::fields.checkbox'),
            type: TypeEnum::CHECKBOX->value
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
    final public function checked(bool $checked): static
    {
        $this->settings[PropEnum::CHECKED->value] = $checked;

        return $this;
    }

    #endregion
}
