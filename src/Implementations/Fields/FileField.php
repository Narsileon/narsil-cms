<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\FileField as Contract;
use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FileField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->props['type'] = 'file';

        $this->setDefaultValue('');
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
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
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

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    final public function setAccept(string $accept): static
    {
        $this->props['accept'] = $accept;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setDefaultValue(string $value): static
    {
        $this->props['value'] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setIcon(string $icon): static
    {
        $this->props['icon'] = $icon;

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
