<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\SelectInput as Contract;
use Narsil\Contracts\Fields\TableInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SelectInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->value('');
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
                Field::NAME => trans('narsil-cms::validation.attributes.options'),
                Field::TYPE => TableInput::class,
                Field::SETTINGS => app(TableInput::class)
                    ->columns([
                        new Field([
                            Field::HANDLE => FieldOption::VALUE,
                            Field::NAME => trans('narsil-cms::validation.attributes.value'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
                                ->required(true)
                                ->toArray(),
                        ]),
                        new Field([
                            Field::HANDLE => FieldOption::LABEL,
                            Field::NAME => trans('narsil-cms::validation.attributes.label'),
                            Field::TYPE => TextInput::class,
                            Field::SETTINGS => app(TextInput::class)
                                ->required(true)
                                ->toArray(),
                        ]),
                    ])
                    ->placeholder(trans('narsil-cms::ui.add'))
                    ->value([])
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'square-chevron-down';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.select');
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
    final public function placeholder(string $placeholder): static
    {
        $this->settings['placeholder'] = $placeholder;

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
    final public function search(bool $search): static
    {
        $this->settings['search'] = $search;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function value(string $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion
}
