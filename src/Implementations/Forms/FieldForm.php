<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Field as AbstractField;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\FieldForm as Contract;
use Narsil\Enums\Fields\VisibilityEnum;
use Narsil\Implementations\AbstractField as ConcreteField;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
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
            $elements = $concrete::getForm();

            foreach ($elements as $key => $element)
            {
                $conditions = [
                    new BlockElementCondition([
                        BlockElementCondition::TARGET_ID => Field::TYPE,
                        BlockElementCondition::OPERATOR => '=',
                        BlockElementCondition::VALUE => $abstract,
                    ]),
                ];

                $blockElement = $this->blockElement(
                    conditions: $conditions,
                    element: $element,
                );

                $settings[] = $blockElement;
            }
        }

        $typeOptions = $this->getTypeOptions();

        $content = [
            $this->mainBlock(array_merge([
                $this->blockElement(
                    new Field([
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Field::HANDLE => Field::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ),
                $this->blockElement(
                    new Field([
                        Field::HANDLE => Field::TYPE,
                        Field::NAME => trans('narsil-cms::validation.attributes.type'),
                        Field::SETTINGS => app(SelectInput::class)
                            ->options($typeOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->required(true)
                            ->value(TextInput::class)
                            ->toArray(),
                    ])
                ),

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
