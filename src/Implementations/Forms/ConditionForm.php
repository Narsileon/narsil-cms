<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Narsil\Cms\Contracts\Fields\SelectField;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\BlockForm as Contract;
use Narsil\Cms\Enums\Database\OperatorEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\AbstractCondition;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Element;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConditionForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::HANDLE => 'condition',
                TemplateTab::LABEL => Str::ucfirst(trans('narsil::validation.attributes.conditions')),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Element::RELATION_CONDITIONS,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.conditions'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::PLACEHOLDER => trans('narsil::ui.add'),
                            Field::TYPE => TableField::class,
                            Field::SETTINGS => app(TableField::class)
                                ->columns([
                                    [
                                        BlockElement::HANDLE => AbstractCondition::HANDLE,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.handle'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => AbstractCondition::OPERATOR,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.operator'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class),
                                            Field::RELATION_OPTIONS => [
                                                OperatorEnum::selectOption(OperatorEnum::EQUALS),
                                                OperatorEnum::selectOption(OperatorEnum::NOT_EQUALS),
                                                OperatorEnum::selectOption(OperatorEnum::GREATER_THAN),
                                                OperatorEnum::selectOption(OperatorEnum::GREATER_THAN_OR_EQUAL),
                                                OperatorEnum::selectOption(OperatorEnum::LESS_THAN),
                                                OperatorEnum::selectOption(OperatorEnum::LESS_THAN_OR_EQUAL),
                                            ],
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => AbstractCondition::VALUE,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.value'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                ]),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
