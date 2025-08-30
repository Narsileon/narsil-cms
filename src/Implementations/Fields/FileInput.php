<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\FileInput as Contract;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FileInput extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->type('file');
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
                Field::HANDLE => $prefix ? "$prefix.accept" : 'accept',
                Field::NAME => trans('narsil::validation.attributes.accept'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'file';
    }

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function accept(string $accept): static
    {
        $this->settings['accept'] = $accept;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function icon(string $icon): static
    {
        $this->settings['icon'] = $icon;

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
    final public function value(string $value): static
    {
        $this->settings['value'] = $value;

        return $this;
    }

    #endregion

    #endregion
}
