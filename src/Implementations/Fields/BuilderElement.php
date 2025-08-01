<?php

namespace Narsil\Implementations\Fields;

#region USE

use Narsil\Contracts\Fields\BuilderElement as Contract;
use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Implementations\AbstractField;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;

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
                Field::NAME => trans('narsil-cms::ui.blocks'),
                Field::TYPE => RelationsInput::class,
                Field::SETTINGS => app(RelationsInput::class)
                    ->createUrl(route('blocks.create'))
                    ->labelKey(Block::NAME)
                    ->options([[
                        'label' => trans('narsil-cms::ui.block'),
                        'href' => route('blocks.create'),
                        'options' => $blockOptions,
                    ]])
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
                    'value' => $block->{Block::ID},
                    'label' => $block->{Block::NAME},
                ];
            })
            ->toArray();
    }

    #endregion
}
