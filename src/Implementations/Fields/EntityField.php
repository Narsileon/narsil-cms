<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\EntityField as Contract;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue('');
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
                BlockElement::HANDLE => Field::PLACEHOLDER,
                BlockElement::LABEL => trans('narsil::validation.attributes.placeholder'),
                BlockElement::TRANSLATABLE => true,
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.multiple" : 'multiple',
                BlockElement::LABEL => trans('narsil::validation.attributes.multiple'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => SwitchField::class,
                    Field::SETTINGS => app(SwitchField::class),
                ],
            ],
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function defaultValue(string $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->set('multiple', $multiple);

        return $this;
    }

    #endregion

    #endregion
}
