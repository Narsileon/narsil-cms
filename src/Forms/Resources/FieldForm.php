<?php

namespace Narsil\Forms\Resources;

#region USE

use Narsil\Contracts\Fields\Select\SelectField;
use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Resources\FieldForm as Contract;
use Narsil\Enums\Fields\VisibilityEnum;
use Narsil\Fields\AbstractField;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldCondition;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        $fields = app()->tagged('fields');

        $typeOptions = $this->getTypeOptions($fields);

        $content = [
            [
                Field::HANDLE => self::MAIN,
                Field::RELATION_FIELDS => [
                    [
                        Field::HANDLE => Field::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::SETTINGS => app(TextField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => Field::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::SETTINGS => app(TextField::class)
                            ->required(true)
                            ->toArray(),
                    ],
                    [
                        Field::HANDLE => Field::TYPE,
                        Field::NAME => trans('narsil-cms::validation.attributes.type'),
                        Field::SETTINGS => app(SelectField::class)
                            ->options($typeOptions)
                            ->placeholder(trans('narsil-cms::placeholders.search'))
                            ->required(true)
                            ->toArray(),
                    ],
                ],
            ],
            [
                Field::HANDLE => self::DATA,
                Field::RELATION_FIELDS => [
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
                ],
            ],
        ];

        $settings = [];

        foreach ($fields as $field)
        {
            $items = $field->getForm();

            foreach ($items as $key => $item)
            {
                $item[Field::VISIBILITY] = VisibilityEnum::HIDDEN_WHEN->value;
                $item[Field::RELATION_CONDITIONS] = [
                    new FieldCondition([
                        FieldCondition::TARGET_ID => Field::TYPE,
                        FieldCondition::OPERATOR => '=',
                        FieldCondition::VALUE => $field::class,
                    ]),
                ];

                $items[$key] = $item;
            }

            $settings = array_merge($settings, $items);
        }

        $content[] = [
            Field::HANDLE => FIELD::SETTINGS,
            Field::RELATION_FIELDS => $settings,
        ];

        return $content;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param iterable<AbstractField> $fields
     *
     * @return array<string>
     */
    protected function getTypeOptions(iterable $fields): array
    {
        $options = [];

        foreach ($fields as $field)
        {
            $options[] = [
                'icon' => $field->icon,
                'label' => $field->label,
                'value' => $field::class,
            ];
        }

        return $options;
    }

    #endregion
}
