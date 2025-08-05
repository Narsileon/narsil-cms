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

        return [
            $this->mainBlock([
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::NAME,
                        Field::NAME => trans('narsil-cms::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::HANDLE,
                        Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true)
                            ->toArray(),
                    ])
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Block([
                        Field::HANDLE => TemplateSection::RELATION_ELEMENTS,
                        Field::NAME => trans('narsil-cms::validation.attributes.elements'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->dataPath(BlockElement::RELATION_ELEMENT)
                            ->options([
                                [
                                    'icon'  => 'box',
                                    'label' => trans('narsil-cms::ui.block'),
                                    'options' => $blockOptions,
                                    'routes' => RouteService::getNames(Block::TABLE),
                                ],
                                [
                                    'icon'  => 'rectangle-ellipsis',
                                    'label' => trans('narsil-cms::ui.field'),
                                    'options' => $fieldOptions,
                                    'routes' => RouteService::getNames(Field::TABLE),
                                ],
                            ])
                            ->toArray(),
                    ])
                ]),
            ]),
            $this->informationBlock(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return [
                    'identifier' => $block->{Block::IDENTIFIER},
                    'label' => $block->{Block::NAME},
                    'value' => $block->{Block::ID},
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
                    'identifier' => $field->{Block::IDENTIFIER},
                    'label' => $field->{Field::NAME},
                    'value' => $field->{Field::ID},
                ];
            })
            ->toArray();
    }

    #endregion
}
