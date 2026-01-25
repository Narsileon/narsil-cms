<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SwitchField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;

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
        $this->defaultValue(false);

        parent::__construct();
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            [
                BlockElement::HANDLE => $prefix ? "$prefix.value" : 'value',
                BlockElement::LABEL => trans('narsil::validation.attributes.default_value'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(array|bool $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    #endregion

    #endregion
}
