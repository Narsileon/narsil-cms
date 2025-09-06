<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxInput;
use Narsil\Contracts\Fields\SectionElement;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Enums\Forms\RuleEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Support\SelectOption;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FieldForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::models.field');
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::models.field');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $settings = [];

        foreach (config('narsil.fields', []) as $abstract => $concrete)
        {
            $elements = $concrete::getForm(Field::SETTINGS);

            $conditions = [
                new BlockElementCondition([
                    BlockElementCondition::TARGET_ID => Field::TYPE,
                    BlockElementCondition::OPERATOR => '=',
                    BlockElementCondition::VALUE => $abstract,
                ]),
            ];

            foreach ($elements as $element)
            {
                $blockElement = new BlockElement([
                    BlockElement::RELATION_CONDITIONS => $conditions,
                    BlockElement::RELATION_ELEMENT => $element,
                ]);

                $settings[] = $blockElement;
            }
        }

        $rulesOptions = static::getRulesOptions();
        $typeOptions = static::getTypeOptions();

        $content = [
            static::mainSection(array_merge([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil::ui.default_name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::HANDLE,
                        Field::NAME => trans('narsil::ui.default_handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::TYPE,
                        Field::NAME => trans('narsil::validation.attributes.type'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($typeOptions)
                            ->placeholder(trans('narsil::placeholders.search'))
                            ->required(true)
                            ->value(TextInput::class),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::NAME => trans('narsil::ui.settings'),
                        Field::TYPE => SectionElement::class,
                        Field::SETTINGS => app(SectionElement::class),
                    ])
                ]),
            ], $settings)),
            new TemplateSection([
                TemplateSection::HANDLE => 'validation',
                TemplateSection::NAME => trans('narsil::ui.validation'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => 'rules',
                            Field::NAME => trans("narsil::ui.rules"),
                            Field::TYPE => CheckboxInput::class,
                            Field::SETTINGS => app(CheckboxInput::class)
                                ->options($rulesOptions),
                        ])
                    ])
                ]
            ]),
            static::informationSection(),
        ];

        return $content;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the rules options.
     *
     * @return array<SelectOption>
     */
    protected static function getRulesOptions(): array
    {
        $options = [];

        foreach (RuleEnum::cases() as $case)
        {
            $options[] = new SelectOption(
                label: trans("narsil::rules.$case->value"),
                value: $case->value
            );
        }

        return $options;
    }

    /**
     * Get the type options.
     *
     * @return array<string>
     */
    protected static function getTypeOptions(): array
    {
        $options = [];

        foreach (config('narsil.fields', []) as $abstract => $concrete)
        {
            $options[] = new SelectOption(
                label: trans('narsil::fields.' . $abstract),
                value: $abstract
            )->icon($concrete::getIcon());
        }

        return $options;
    }

    #endregion
}
