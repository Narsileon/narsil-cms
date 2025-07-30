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
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldCondition;

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
        $Blocktings = [];

        foreach ($this->implementations as $abstract => $concrete)
        {
            $items = $concrete::getForm();

            foreach ($items as $key => $item)
            {
                $item[Field::VISIBILITY] = VisibilityEnum::HIDDEN_WHEN->value;
                $item[Field::RELATION_CONDITIONS] = [
                    new FieldCondition([
                        FieldCondition::TARGET_ID => Field::TYPE,
                        FieldCondition::OPERATOR => '=',
                        FieldCondition::VALUE => $abstract,
                    ]),
                ];

                $items[$key] = $item;
            }

            $Blocktings = array_merge($Blocktings, $items);
        }

        $typeOptions = $this->getTypeOptions();

        $content = [
            $this->main([
                [
                    Field::HANDLE => Field::NAME,
                    Field::NAME => trans('narsil-cms::validation.attributes.name'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => Field::HANDLE,
                    Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                    Field::SETTINGS => app(TextInput::class)
                        ->required(true)
                        ->toArray(),
                ],
                [
                    Field::HANDLE => Field::TYPE,
                    Field::NAME => trans('narsil-cms::validation.attributes.type'),
                    Field::SETTINGS => app(SelectInput::class)
                        ->options($typeOptions)
                        ->placeholder(trans('narsil-cms::placeholders.search'))
                        ->required(true)
                        ->value(TextInput::class)
                        ->toArray(),
                ],
                [
                    Block::HANDLE => FIELD::SETTINGS,
                    Block::NAME => trans('narsil-cms::ui.Blocktings'),
                    Block::RELATION_ELEMENTS => $Blocktings,
                ]
            ]),
            $this->information([
                [
                    Field::HANDLE => Field::ID,
                    Field::NAME => trans('narsil-cms::validation.attributes.id'),
                ],
                [
                    Field::HANDLE => Field::CREATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.created_at'),
                ],
                [
                    Field::HANDLE => Field::UPDATED_AT,
                    Field::NAME => trans('narsil-cms::validation.attributes.updated_at'),
                ],
            ]),
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
