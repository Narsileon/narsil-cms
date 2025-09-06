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
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class CheckboxInput extends AbstractField implements Contract
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
            new Field([
                Field::HANDLE => Field::RELATION_OPTIONS,
                Field::NAME => trans('narsil::validation.attributes.options'),
                Field::TYPE => TableInput::class,
                Field::SETTINGS => app(TableInput::class)
                    ->setColumns([
                        new Field([
                            Field::HANDLE => FieldOption::VALUE,
                            Field::NAME => trans('narsil::validation.attributes.value'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
                                ->setRequired(true),
                        ]),
                        new Field([
                            Field::HANDLE => FieldOption::LABEL,
                            Field::NAME => trans('narsil::validation.attributes.label'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
                                ->setRequired(true),
                        ]),
                    ])
                    ->setPlaceholder(trans('narsil::ui.add')),
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

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(array|bool $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setOptions(array $options): static
    {
        $this->props['options'] = $options;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setRequired(bool $required): static
    {
        $this->props['required'] = $required;

        return $this;
    }

    #endregion

    #endregion
}
