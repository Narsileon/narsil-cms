<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\SelectField as Contract;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

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
                BlockElement::HANDLE => Field::RELATION_OPTIONS,
                BlockElement::LABEL => trans('narsil::validation.attributes.options'),
                BlockElement::RELATION_BASE => [
                    Field::PLACEHOLDER => trans('narsil::ui.add'),
                    Field::TYPE => TableField::class,
                    Field::SETTINGS => app(TableField::class)
                        ->columns([
                            [
                                BlockElement::HANDLE => FieldOption::VALUE,
                                BlockElement::LABEL => trans('narsil::validation.attributes.value'),
                                BlockElement::REQUIRED => true,
                                BlockElement::RELATION_BASE => [
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
                                ],
                            ],
                            [
                                BlockElement::HANDLE => FieldOption::LABEL,
                                BlockElement::LABEL => trans('narsil::validation.attributes.label'),
                                BlockElement::REQUIRED => true,
                                BlockElement::TRANSLATABLE => true,
                                BlockElement::RELATION_BASE => [
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
                                ],
                            ],
                        ]),
                ],
            ],
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
