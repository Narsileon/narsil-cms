<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\EmailField as Contract;
use Narsil\Cms\Contracts\Fields\SwitchField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EmailField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->set('type', 'email');

        $this->defaultvalue('');

        parent::__construct();
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
                BlockElement::HANDLE => Field::PLACEHOLDER,
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.placeholder'),
                BlockElement::TRANSLATABLE => true,
                BlockElement::RELATION_BASE => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
            [
                BlockElement::HANDLE => $prefix ? "$prefix.multiple" : 'multiple',
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.multiple'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => SwitchField::class,
                    Field::SETTINGS => app(SwitchField::class),
                ],
            ],
        ];
    }

    #region • FLUENT

    /**
     * {@inheritDoc}
     */
    final public function autoComplete(string $autoComplete): static
    {
        $this->set('autoComplete', $autoComplete);

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

    /**
     * {@inheritDoc}
     */
    final public function multiple(bool $multiple): static
    {
        $this->set('multiple', $multiple);

        return $this;
    }

    #endregion

    #endregion
}
