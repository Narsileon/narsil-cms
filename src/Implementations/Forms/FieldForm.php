<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\ValidationRule;
use Narsil\Services\Models\FieldService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Field::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $settings = [];

        $abstract = request()->get(Field::TYPE);

        if ($abstract)
        {
            $concrete = Config::get("narsil.bindings.fields.$abstract");

            $settings = $concrete::getForm(Field::SETTINGS);
        }

        $typeSelectOptions = static::getTypeSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => array_filter([
                    [
                        TemplateTabElement::DESCRIPTION => trans('narsil::descriptions.field_handle'),
                        TemplateTabElement::HANDLE => Field::HANDLE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.handle'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => trans('narsil::descriptions.field_label'),
                        TemplateTabElement::HANDLE => Field::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => trans('narsil::descriptions.field_description'),
                        TemplateTabElement::HANDLE => Field::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.description'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Field::TYPE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.type'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::PLACEHOLDER => trans('narsil::placeholders.search'),
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->reload('form'),
                            Field::RELATION_OPTIONS => $typeSelectOptions,
                        ],
                    ],
                    !empty($settings) ? [
                        TemplateTabElement::LABEL => trans('narsil::ui.settings'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Block::COLLAPSIBLE => true,
                            Block::RELATION_ELEMENTS =>  $settings,
                        ],
                    ] : null,
                ]),
            ],
            [
                TemplateTab::HANDLE => 'validation',
                TemplateTab::LABEL => trans('narsil::ui.validation'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Field::RELATION_VALIDATION_RULES,
                        TemplateTabElement::LABEL => trans("narsil::ui.rules"),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => CheckboxField::class,
                            Field::SETTINGS => app(CheckboxField::class)
                                ->defaultValue([]),
                            Field::RELATION_OPTIONS => ValidationRule::selectOptions(),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the type select options.
     *
     * @return array<SelectOption>
     */
    protected static function getTypeSelectOptions(): array
    {
        $options = [];

        foreach (Config::get('narsil.fields', []) as $field)
        {
            $icon = FieldService::getIcon($field);
            $label = trans('narsil::fields.' . $field);

            $options[] = new SelectOption()
                ->optionIcon($icon)
                ->optionLabel($label)
                ->optionValue($field);
        }

        return $options;
    }

    #endregion
}
