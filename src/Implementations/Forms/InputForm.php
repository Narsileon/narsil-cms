<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\InputForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Forms\Input;
use Narsil\Models\ValidationRule;
use Narsil\Services\Models\FieldService;
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
    protected function getLayout(): array
    {
        $settings = [];

        $abstract = request()->get(Input::TYPE);

        if ($abstract)
        {
            $concrete = Config::get("narsil.bindings.fields.$abstract");

            $elements = $concrete::getForm(Input::SETTINGS);

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
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Input::LABEL,
                            Field::LABEL => trans('narsil::ui.default_name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Input::HANDLE,
                            Field::LABEL => trans('narsil::ui.default_handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Input::TYPE,
                            Field::LABEL => trans('narsil::validation.attributes.type'),
                            Field::PLACEHOLDER => trans('narsil::placeholders.search'),
                            Field::REQUIRED => true,
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => $typeSelectOptions,
                            Field::SETTINGS => app(SelectField::class)
                                ->reload('form'),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Block([
                            Block::COLLAPSIBLE => true,
                            Block::LABEL => trans('narsil::ui.settings'),
                            Block::RELATION_ELEMENTS =>  $settings,
                        ]),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'validation',
                TemplateTab::LABEL => trans('narsil::ui.validation'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Input::REQUIRED,
                            Field::LABEL => trans('narsil::validation.attributes.required'),
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Input::RELATION_VALIDATION_RULES,
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
