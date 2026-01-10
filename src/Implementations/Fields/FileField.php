<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\FileField as Contract;
use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;

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
        $this->set('type', 'file');

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
                BlockElement::HANDLE => $prefix ? "$prefix.accept" : 'accept',
                BlockElement::LABEL => trans('narsil::validation.attributes.accept'),
                BlockElement::RELATION_ELEMENT => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function accept(string $accept): static
    {
        $this->set('accept', $accept);

        return $this;
    }

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
    final public function icon(string $icon): static
    {
        $this->set('icon', $icon);

        return $this;
    }

    #endregion

    #endregion
}
