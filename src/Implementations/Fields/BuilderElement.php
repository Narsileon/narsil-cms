<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\BuilderElement as Contract;
use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
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
                    ->labelKey(Block::NAME)
                    ->options([
                        [
                            'icon'  => 'box',
                            'label' => trans('narsil-cms::ui.block'),
                            'options' => $blockOptions,
                            'routes' => RouteService::getNames(Block::TABLE),
                        ],
                    ])
                    ->value([])
                    ->toArray(),
            ]),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public static function getIcon(): string
    {
        return 'square-mouse-pointer';
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
                    'identifier' => $block->{Block::IDENTIFIER},
                    'label' => $block->{Block::NAME},
                    'value' => $block->{Block::ID},
                ];
            })
            ->toArray();
    }

    #endregion
}
