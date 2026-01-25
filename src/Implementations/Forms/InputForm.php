<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\InputForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Forms\Input;
use Narsil\Models\ValidationRule;
use Narsil\Services\Models\FieldService;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Input::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $settings = [];

        $abstract = request()->get(Input::TYPE);

        if ($abstract)
        {
            $concrete = Config::get("narsil.bindings.fields.$abstract");

            $settings = $concrete::getForm(Input::SETTINGS);
        }

        $typeSelectOptions = static::getTypeSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Input::TABLE, Input::HANDLE),
                        TemplateTabElement::HANDLE => Input::HANDLE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.handle'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Input::TABLE, Input::LABEL),
                        TemplateTabElement::HANDLE => Input::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Input::TABLE, Input::DESCRIPTION),
                        TemplateTabElement::HANDLE => Input::DESCRIPTION,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.description'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Input::TYPE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.type'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::PLACEHOLDER => trans('narsil::field-placeholders.search'),
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->reload('form'),
                            Field::RELATION_OPTIONS => $typeSelectOptions,
                        ],
                    ],
                    [
                        TemplateTabElement::RELATION_BASE => [
                            Block::COLLAPSIBLE => true,
                            Block::LABEL => trans('narsil::ui.settings'),
                            Block::RELATION_ELEMENTS =>  $settings,
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'validation',
                TemplateTab::LABEL => trans('narsil::ui.validation'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Input::RELATION_VALIDATION_RULES,
                        TemplateTabElement::LABEL => trans("narsil::ui.rules"),
                        TemplateTabElement::RELATION_BASE => [
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

        foreach (Config::get('narsil.inputs', []) as $input)
        {
            $icon = FieldService::getIcon($input);
            $label = trans('narsil::fields.' . $input);

            $options[] = new SelectOption()
                ->optionIcon($icon)
                ->optionLabel($label)
                ->optionValue($input);
        }

        return $options;
    }

    #endregion
}
