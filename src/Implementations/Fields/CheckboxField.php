<?php

namespace Narsil\Cms\Implementations\Fields;

#region USE

use Narsil\Cms\Contracts\Fields\CheckboxField as Contract;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Implementations\AbstractField;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CheckboxField extends AbstractField implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        $this->defaultValue(false);

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
                BlockElement::HANDLE => $prefix ? "$prefix.value" : 'value',
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.default_value'),
                BlockElement::RELATION_BASE => [
                    Field::TYPE => Contract::class,
                    Field::SETTINGS => app(Contract::class),
                ],
            ],
            [
                BlockElement::HANDLE => Field::RELATION_OPTIONS,
                BlockElement::LABEL => trans('narsil-cms::validation.attributes.options'),
                BlockElement::RELATION_BASE => [
                    Field::PLACEHOLDER => trans('narsil-cms::ui.add'),
                    Field::TYPE => TableField::class,
                    Field::SETTINGS => app(TableField::class)
                        ->columns([
                            [
                                BlockElement::HANDLE => FieldOption::VALUE,
                                BlockElement::LABEL => trans('narsil-cms::validation.attributes.value'),
                                BlockElement::REQUIRED => true,
                                BlockElement::RELATION_BASE => [
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
                                ],
                            ],
                            [
                                BlockElement::HANDLE => FieldOption::LABEL,
                                BlockElement::LABEL => trans('narsil-cms::validation.attributes.label'),
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
    final public function defaultValue(array|bool $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    #endregion

    #endregion
}
