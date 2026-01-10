<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Services\DatabaseService;

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
    public static function replicate(Block $block): void
    {
        $replicated = $block->replicate();

        $replicated
            ->fill([
                Block::HANDLE => DatabaseService::generateUniqueValue($replicated, Block::HANDLE, $block->{Block::HANDLE}),
            ])
            ->save();

        static::syncBlockElements($replicated, $block->elements()->get()->toArray());
    }

    /**
     * @param Block $block
     * @param array $elements
     *
     * @return void
     */
    public static function syncBlockElements(Block $block, array $elements): void
    {
        $uuids = [];

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, BlockElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $blockElement = BlockElement::updateOrCreate([
                BlockElement::OWNER_ID => $block->{Block::ID},
                BlockElement::HANDLE => Arr::get($element, BlockElement::HANDLE),
                BlockElement::BASE_TYPE => $table,
                BlockElement::BASE_ID => $id,
            ], [
                BlockElement::DESCRIPTION => Arr::get($element, BlockElement::DESCRIPTION),
                BlockElement::LABEL => Arr::get($element, BlockElement::LABEL),
                BlockElement::POSITION => $position,
                BlockElement::REQUIRED => Arr::get($element, BlockElement::REQUIRED, false),
                BlockElement::TRANSLATABLE => Arr::get($element, BlockElement::TRANSLATABLE, false),
                BlockElement::WIDTH => Arr::get($element, BlockElement::WIDTH, 100),
            ]);

            ElementService::syncConditions($blockElement, Arr::get($element, BlockElement::RELATION_CONDITIONS, []));

            $uuids[] = $blockElement->{BlockElement::UUID};
        }

        $block
            ->elements()
            ->whereNotIn(BlockElement::UUID, $uuids)
            ->delete();
    }

    #endregion
}
