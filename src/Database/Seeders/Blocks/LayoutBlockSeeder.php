<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Fields\SizeFieldSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class LayoutBlockSeeder extends Seeder
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
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'layout'))
        {
            return $block;
        }

        $PaddingBlockSeeder = new PaddingBlockSeeder()->run();
        $SizeFieldSeeder = new SizeFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $SizeFieldSeeder,
                [
                    BlockElement::HANDLE => self::SIZE,
                    BlockElement::LABEL => 'Size',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $PaddingBlockSeeder,
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
