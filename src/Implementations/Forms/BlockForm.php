<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        $elementOptions = static::getElementOptions();

        return [
            $this->mainBlock([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::RELATION_ELEMENTS,
                        Field::NAME => trans('narsil-cms::ui.fields'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->createUrl(route('fields.create'))
                            ->labelKey(BlockElement::RELATION_ELEMENT . '.name')
                            ->options($elementOptions)
                            ->toArray(),
                    ])
                ]),
            ]),
            $this->informationBlock(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    protected static function getElementOptions(): array
    {
        return [
            [
                'label' => 'blocks',
                'options' => static::getBlockOptions(),
            ],
            [
                'label' => 'fields',
                'options' => static::getFieldOptions(),
            ],
        ];
    }

    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return [
                    'value' => $block->{Block::ID},
                    'label' => $block->{Block::NAME},
                ];
            })
            ->toArray();
    }

    protected static function getFieldOptions(): array
    {
        return Field::query()
            ->orderBy(Field::NAME)
            ->get()
            ->map(function (Field $field)
            {
                return [
                    'value' => $field->{Field::ID},
                    'label' => $field->{Field::NAME},
                ];
            })
            ->toArray();
    }


    #endregion
}
