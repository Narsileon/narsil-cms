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
abstract class CallToActionBlock
{
    #region CONSTANTS

    /**
     * The name of the "label" field.
     *
     * @var string
     */
    public const LABEL = 'label';

    /**
     * The name of the "layout" field.
     *
     * @var string
     */
    public const LAYOUT = 'layout';

    /**
     * The name of the "link" block.
     *
     * @var string
     */
    public const LINK = 'link';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'call_to_action'))
        {
            return $block;
        }

        $layoutBlock = LayoutBlock::run();
        $linkBlock = LinkBlock::run();
        $titleField = TitleField::run();

        return Block::factory()
            ->hasAttached(
                $layoutBlock,
                [
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Layout',
                    BlockElement::POSITION => 0,
                ],
                Block::RELATION_BLOCKS
            )
            ->hasAttached(
                $titleField,
                [
                    BlockElement::HANDLE => self::LABEL,
                    BlockElement::LABEL  => 'Label',
                    BlockElement::POSITION => 1,
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
                    BlockElement::POSITION => 2,
                ],
                Block::RELATION_BLOCKS
            )
            ->create([
                Block::HANDLE => 'call_to_action',
                Block::LABEL => 'Call To Action',
            ]);
    }

    #endregion
}
