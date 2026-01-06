<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SelectField as Contract;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SelectField extends AbstractField implements Contract
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
                            Field::TRANSLATABLE => true,
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
    final public function defaultValue(string $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function displayValue(bool $displayValue): static
    {
        $this->set('displayValue', $displayValue);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function href(string $href): static
    {
        $this->set('href', $href);

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

    /**
     * {@inheritDoc}
     */
    final public function reload(string $reload): static
    {
        $this->set('reload', $reload);

        return $this;
    }

    #endregion

    #endregion
}
