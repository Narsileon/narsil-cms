<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SectionElement;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
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
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::models.field');
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
            static::informationSection(),
        ];

        return $content;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected static function getTypeOptions(): array
    {
        $options = [];

        foreach (config('narsil.fields', []) as $abstract => $concrete)
        {
            $options[] = new SelectOption($concrete::getLabel(), $abstract)
                ->icon($concrete::getIcon());
        }

        return $options;
    }

    #endregion
}
