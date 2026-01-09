<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Interfaces\IHasElement;
use Narsil\Models\AbstractCondition;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;

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
                        TemplateTabElement::HANDLE => IHasElement::RELATION_CONDITIONS,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.conditions'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::PLACEHOLDER => trans('narsil::ui.add'),
                            Field::TYPE => TableField::class,
                            Field::SETTINGS => app(TableField::class)
                                ->columns([
                                    [
                                        BlockElement::HANDLE => AbstractCondition::HANDLE,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.handle'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_ELEMENT => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => AbstractCondition::OPERATOR,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.operator'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_ELEMENT => [
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => AbstractCondition::VALUE,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.value'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_ELEMENT => [
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
