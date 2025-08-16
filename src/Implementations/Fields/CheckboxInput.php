<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\CheckboxInput as Contract;
use Narsil\Contracts\Fields\TableInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CheckboxInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->value(false);
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
            new Field([
                Field::HANDLE => Field::RELATION_OPTIONS,
                Field::NAME => trans('narsil::validation.attributes.options'),
                Field::TYPE => TableInput::class,
                Field::SETTINGS => app(TableInput::class)
                    ->columns([
                        new Field([
                            Field::HANDLE => FieldOption::VALUE,
                            Field::NAME => trans('narsil::validation.attributes.value'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
                                ->required(true),
                        ]),
                        new Field([
                            Field::HANDLE => FieldOption::LABEL,
                            Field::NAME => trans('narsil::validation.attributes.label'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
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
        return 'checkbox';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil::fields.checkbox');
    }

    #endregion

    #region FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function inline(bool $inline): static
    {
        $this->settings['_inlineReverse'] = $inline;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function options(array $options): static
    {
        $this->settings['options'] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function required(bool $required): static
    {
        $this->settings['required'] = $required;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(bool $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
