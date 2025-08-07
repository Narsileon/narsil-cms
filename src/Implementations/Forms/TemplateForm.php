<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function elements(): array
    {
        $blockOptions = static::getBlockOptions();
        $fieldOptions = static::getFieldOptions();
        $widthOptions = static::getWidthOptions();

        return [
            $this->mainBlock([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::RELATION_SECTIONS,
                        Field::NAME => trans('narsil-cms::validation.attributes.elements'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->form([
                                new Field([
                                    Field::HANDLE => TemplateSection::RELATION_ELEMENTS,
                                    Field::NAME => trans('narsil-cms::validation.attributes.elements'),
                                    Field::TYPE => RelationsInput::class,
                                    Field::SETTINGS => app(RelationsInput::class)
                                        ->form([
                                            new Field([
                                                Field::HANDLE => Block::NAME,
                                                Field::NAME => trans('narsil-cms::validation.attributes.name'),
                                                Field::TYPE => TextInput::class,
                                                Field::SETTINGS => app(TextInput::class)
                                                    ->required(true),
                                            ]),
                                            new Field([
                                                Field::HANDLE => Block::HANDLE,
                                                Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                                                Field::TYPE => TextInput::class,
                                                Field::SETTINGS => app(TextInput::class)
                                                    ->required(true),
                                            ]),
                                        ])
                                        ->addOption(
                                            identifier: Block::TABLE,
                                            label: trans('narsil-cms::ui.block'),
                                            optionLabel: BlockElement::NAME,
                                            optionValue: BlockElement::HANDLE,
                                            options: $blockOptions,
                                            routes: RouteService::getNames(Block::TABLE),
                                        )
                                        ->addOption(
                                            identifier: Field::TABLE,
                                            label: trans('narsil-cms::ui.field'),
                                            optionLabel: BlockElement::NAME,
                                            optionValue: BlockElement::HANDLE,
                                            options: $fieldOptions,
                                            routes: RouteService::getNames(Field::TABLE),
                                        )
                                        ->widthOptions($widthOptions),
                                ])
                            ])
                            ->placeholder(trans('narsil-cms::ui.add_section')),
                    ])
                ]),
            ]),
            $this->informationBlock(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return [
                    'icon' => $block->{Block::ATTRIBUTE_ICON},
                    'identifier' => $block->{Block::ATTRIBUTE_IDENTIFIER},
                    'label' => $block->{Block::NAME},
                    'value' => $block->{Block::HANDLE},
                ];
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getFieldOptions(): array
    {
        return Field::query()
            ->orderBy(Field::NAME)
            ->get()
            ->map(function (Field $field)
            {
                return [
                    'icon' => $field->{Field::ATTRIBUTE_ICON},
                    'identifier' => $field->{Field::ATTRIBUTE_IDENTIFIER},
                    'label' => $field->{Field::NAME},
                    'value' => $field->{Field::HANDLE},
                ];
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getWidthOptions(): array
    {
        return [
            ['label' => '25%', 'value' => 25],
            ['label' => '33%', 'value' => 33],
            ['label' => '50%', 'value' => 50],
            ['label' => '67%', 'value' => 67],
            ['label' => '75%', 'value' => 75],
            ['label' => '100%', 'value' => 100],
        ];
    }

    #endregion
}
