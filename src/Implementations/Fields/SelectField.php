<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SelectField as Contract;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

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
                Field::NAME => trans('narsil::validation.attributes.options'),
                Field::TYPE => TableField::class,
                Field::SETTINGS => app(TableField::class)
                    ->columns([
                        new Field([
                            Field::HANDLE => FieldOption::VALUE,
                            Field::NAME => trans('narsil::validation.attributes.value'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->required(true),
                        ]),
                        new Field([
                            Field::HANDLE => FieldOption::LABEL,
                            Field::NAME => trans('narsil::validation.attributes.label'),
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->required(true),
                        ]),
                    ])
                    ->placeholder(trans('narsil::ui.add')),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'select';
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
    final public function multiple(bool $multiple): static
    {
        $this->set('multiple', $multiple);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->set('options', $options);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function placeholder(string $placeholder): static
    {
        $this->set('placeholder', $placeholder);

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

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->set('required', $required);

        return $this;
    }

    #endregion

    #endregion
}
