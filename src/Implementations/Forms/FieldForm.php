<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Field as AbstractField;
use Narsil\Contracts\Fields\SectionElement;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Implementations\AbstractField as ConcreteField;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\BlockElementCondition;
use Narsil\Models\Elements\Field;

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
        $this->implementations = config('narsil.fields', []);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<AbstractField,ConcreteField>
     */
    private readonly array $implementations;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        $settings = [];

        foreach ($this->implementations as $abstract => $concrete)
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

        $typeOptions = $this->getTypeOptions();

        $content = [
            $this->mainBlock(array_merge([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil-cms::ui.default_name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::HANDLE,
                        Field::NAME => trans('narsil-cms::ui.default_handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Field::TYPE,
                        Field::NAME => trans('narsil-cms::validation.attributes.type'),
                        Field::TYPE => SelectInput::class,
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($typeOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->required(true)
                            ->value(TextInput::class),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::NAME => trans('narsil-cms::ui.settings'),
                        Field::TYPE => SectionElement::class,
                        Field::SETTINGS => app(SectionElement::class),
                    ])
                ]),
            ], $settings)),
            $this->informationBlock(),
        ];

        return $content;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected function getTypeOptions(): array
    {
        $options = [];

        foreach ($this->implementations as $abstract => $concrete)
        {
            $options[] = [
                'icon' => $concrete::getIcon(),
                'label' => $concrete::getLabel(),
                'value' => $abstract,
            ];
        }

        return $options;
    }

    #endregion
}
