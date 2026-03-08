<?php

namespace Narsil\Cms\Implementations\Actions\Blocks;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Blocks\SyncBlockElements as Contract;
use Narsil\Cms\Contracts\Actions\Elements\SyncElementConditions;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncBlockElements extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Block $block, array $elements): Block
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

            app(SyncElementConditions::class)
                ->run($blockElement, Arr::get($element, BlockElement::RELATION_CONDITIONS, []));

            $uuids[] = $blockElement->{BlockElement::UUID};
        }

        $block
            ->elements()
            ->whereNotIn(BlockElement::UUID, $uuids)
            ->delete();

        return $block;
    }

    #endregion
}
