<?php

namespace Narsil\Cms\Database\Factories\Blocks;

#region USE

use Narsil\Cms\Database\Factories\Fields\SizeField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class LayoutBlock
{
    #region CONSTANTS

    /**
     * The name of the "padding" block.
     *
     * @var string
     */
    public const PADDING = 'padding';

    /**
     * The name of the "size" field.
     *
     * @var string
     */
    public const SIZE = 'size';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'layout'))
        {
            return $block;
        }

        $paddingBlock = PaddingBlock::run();
        $sizeField = SizeField::run();

        return Block::factory()
            ->hasAttached(
                $sizeField,
                [
                    BlockElement::HANDLE => self::SIZE,
                    BlockElement::LABEL => 'Size',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $paddingBlock,
                [
                    BlockElement::HANDLE => self::PADDING,
                    BlockElement::LABEL => 'Padding',
                    BlockElement::POSITION => 1,
                ],
                Block::RELATION_BLOCKS
            )
            ->create([
                Block::COLLAPSIBLE => true,
                Block::HANDLE => 'layout',
                Block::LABEL => 'Layout',
            ]);
    }

    #endregion
}
