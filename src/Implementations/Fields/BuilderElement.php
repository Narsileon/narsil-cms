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
use Narsil\Support\SelectOption;

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
                Field::NAME => trans('narsil::validation.attributes.blocks'),
                Field::TYPE => RelationsInput::class,
                Field::SETTINGS => app(RelationsInput::class)
                    ->addOption(
                        identifier: Block::TABLE,
                        label: trans('narsil::models.block'),
                        optionLabel: BlockElement::NAME,
                        optionValue: BlockElement::HANDLE,
                        options: $blockOptions,
                        routes: RouteService::getNames(Block::TABLE),
                    )
                    ->unique(true),
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
        return trans('narsil::fields.builder');
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
                return new SelectOption($block->{Block::NAME}, $block->{Block::ID})
                    ->icon($block->{Block::ATTRIBUTE_ICON})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER});
            })
            ->toArray();
    }

    #endregion
}
