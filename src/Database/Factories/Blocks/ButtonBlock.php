<?php

namespace Narsil\Cms\Database\Factories\Blocks;

#region USE

use Narsil\Cms\Database\Factories\Fields\TitleField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ButtonBlock
{
    #region CONSTANTS

    /**
     * The name of the "label" field.
     *
     * @var string
     */
    public const LABEL = 'label';

    /**
     * The name of the "limk" block.
     *
     * @var string
     */
    public const LINK = 'limk';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'button'))
        {
            return $block;
        }

        $linkBlock = LinkBlock::run();
        $titleField = TitleField::run();

        return Block::factory()
            ->hasAttached(
                $titleField,
                [
                    BlockElement::HANDLE => self::LABEL,
                    BlockElement::LABEL => 'Label',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $linkBlock,
                [
                    BlockElement::HANDLE => self::LINK,
                    BlockElement::LABEL  => 'Link',
                    BlockElement::POSITION => 1,
                ],
                Block::RELATION_BLOCKS
            )
            ->create([
                Block::HANDLE => 'button',
                Block::LABEL => 'Button',
            ]);
    }

    #endregion
}
