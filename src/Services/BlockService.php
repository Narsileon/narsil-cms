<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class BlockService
{
    #region PUBLIC METHODS

    /**
     * @param Block $block
     *
     * @return void
     */
    public static function replicateBlock(Block $block): void
    {
        $replicated = $block->replicate();

        $replicated
            ->fill([
                Block::HANDLE => DatabaseService::generateUniqueValue($replicated, Block::HANDLE, $block->{Block::HANDLE}),
            ])
            ->save();

        static::syncElements($replicated, $block->elements()->get()->toArray());
    }

    /**
     * @param Block $block
     * @param array $elements
     *
     * @return void
     */
    public static function syncElements(Block $block, array $elements): void
    {
        $block->blocks()->detach();
        $block->fields()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, BlockElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || !Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                BlockElement::HANDLE => Arr::get($element, BlockElement::HANDLE),
                BlockElement::NAME => json_encode(Arr::get($element, BlockElement::NAME)),
                BlockElement::POSITION => $position,
                BlockElement::WIDTH => Arr::get($element, BlockElement::WIDTH, 100),
            ];

            match ($table)
            {
                Block::TABLE => $block->blocks()->attach($id, $attributes),
                Field::TABLE => $block->fields()->attach($id, $attributes),
                default => null,
            };
        }
    }

    #endregion
}
