<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
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
    protected function getLayout(): array
    {
        $settings = [];

        $abstract = request()->get(Field::TYPE);

        if ($abstract)
        {
            $concrete = Config::get("narsil.bindings.fields.$abstract");

            $elements = $concrete::getForm(Field::SETTINGS);

            foreach ($elements as $element)
            {
                $blockElement = new BlockElement([
                    BlockElement::RELATION_ELEMENT => $element,
                ]);

                $settings[] = $blockElement;
            }
        }

        $typeSelectOptions = static::getTypeSelectOptions();

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => array_filter([
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::LABEL,
                            Field::LABEL => trans('narsil::ui.default_name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::HANDLE,
                            Field::LABEL => trans('narsil::ui.default_handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::TRANSLATABLE,
                            Field::LABEL => trans('narsil::validation.attributes.translatable'),
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::TYPE,
                            Field::LABEL => trans('narsil::validation.attributes.type'),
                            Field::PLACEHOLDER => trans('narsil::placeholders.search'),
                            Field::REQUIRED => true,
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => $typeSelectOptions,
                            Field::SETTINGS => app(SelectField::class)
                                ->reload('form'),
                        ]),
                    ]),
                    !empty($settings) ? new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Block([
                            Block::COLLAPSIBLE => true,
                            Block::LABEL => trans('narsil::ui.settings'),
                            Block::RELATION_ELEMENTS =>  $settings,
                        ]),
                    ]) : null,
                ]),
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'validation',
                TemplateTab::LABEL => trans('narsil::ui.validation'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::REQUIRED,
                            Field::LABEL => trans('narsil::validation.attributes.required'),
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Field::RELATION_VALIDATION_RULES,
                            Field::LABEL => trans("narsil::ui.rules"),
                            Field::TYPE => CheckboxField::class,
                            Field::RELATION_OPTIONS => ValidationRule::selectOptions(),
                            Field::SETTINGS => app(CheckboxField::class)
                                ->defaultValue([]),
                        ]),
                    ]),
                ],
            ]),
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
