<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField as Contract;
use Narsil\Contracts\Fields\TableField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;

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
        $this->defaultValue(false);
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
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
            [
                BlockElement::HANDLE => Field::RELATION_OPTIONS,
                BlockElement::LABEL => trans('narsil::validation.attributes.options'),
                BlockElement::RELATION_ELEMENT => [
                    Field::PLACEHOLDER => trans('narsil::ui.add'),
                    Field::TYPE => TableField::class,
                    Field::SETTINGS => app(TableField::class)
                        ->columns([
                            [
                                BlockElement::HANDLE => FieldOption::VALUE,
                                BlockElement::LABEL => trans('narsil::validation.attributes.value'),
                                BlockElement::REQUIRED => true,
                                BlockElement::RELATION_ELEMENT => [
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
                                ],
                            ],
                            [
                                BlockElement::HANDLE => FieldOption::LABEL,
                                BlockElement::LABEL => trans('narsil::validation.attributes.label'),
                                BlockElement::REQUIRED => true,
                                BlockElement::TRANSLATABLE => true,
                                BlockElement::RELATION_ELEMENT => [
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
                                ],
                            ],
                        ]),
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
