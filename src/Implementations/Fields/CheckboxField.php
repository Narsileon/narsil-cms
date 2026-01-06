<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxField as Contract;
use Narsil\Contracts\Fields\TableField;
use Narsil\Implementations\AbstractField;
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
            new Field([
                Field::HANDLE => $prefix ? "$prefix.value" : 'value',
                Field::LABEL => trans('narsil::validation.attributes.default_value'),
                Field::TYPE => Contract::class,
                Field::SETTINGS => app(Contract::class),
            ]),
            new Field([
                Field::HANDLE => Field::RELATION_OPTIONS,
                Field::LABEL => trans('narsil::validation.attributes.options'),
                Field::PLACEHOLDER => trans('narsil::ui.add'),
                Field::TYPE => TableField::class,
                Field::SETTINGS => app(TableField::class)
                    ->columns([
                        new Field([
                            Field::HANDLE => FieldOption::VALUE,
                            Field::LABEL => trans('narsil::validation.attributes.value'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                        new Field([
                            Field::HANDLE => FieldOption::LABEL,
                            Field::LABEL => trans('narsil::validation.attributes.label'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
            ]),
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
