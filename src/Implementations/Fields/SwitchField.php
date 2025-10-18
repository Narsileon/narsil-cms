<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SwitchField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SwitchField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->setDefaultValue(false);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        return [
            new Field([
                Field::HANDLE => $prefix ? "$prefix.value" : 'value',
                Field::NAME => trans('narsil::validation.attributes.default_value'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'switch';
    }

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(array|bool $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    #endregion

    #endregion
}
