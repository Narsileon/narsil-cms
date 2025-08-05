<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\BuilderElement as Contract;
use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BuilderElement extends AbstractField implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getForm(?string $prefix = null): array
    {
        $blockOptions = static::getBlockOptions();

        return [
            new Field([
                Field::HANDLE => Field::RELATION_BLOCKS,
                Field::NAME => trans('narsil-cms::validation.attributes.blocks'),
                Field::TYPE => RelationsInput::class,
                Field::SETTINGS => app(RelationsInput::class)
                    ->options([
                        [
                            'icon'  => 'box',
                            'identifier' => Block::TABLE,
                            'label' => trans('narsil-cms::ui.block'),
                            'options' => $blockOptions,
                            'optionLabel' => BlockElement::NAME,
                            'optionValue' => BlockElement::HANDLE,
                            'routes' => RouteService::getNames(Block::TABLE),
                        ],
                    ])
                    ->unique(true)
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'builder';
    }

    /**
     * {@inheritDoc}
     */
    public static function getLabel(): string
    {
        return trans('narsil-cms::fields.builder');
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
                    'identifier' => $block->{Block::ATTRIBUTE_IDENTIFIER},
                    'label' => $block->{Block::NAME},
                    'value' => $block->{Block::ID},
                    'data' => [
                        Block::ID => $block->{Block::ID},
                        Block::HANDLE => $block->{Block::HANDLE},
                        Block::NAME => $block->{Block::NAME},
                    ]
                ];
            })
            ->toArray();
    }

    #endregion
}
