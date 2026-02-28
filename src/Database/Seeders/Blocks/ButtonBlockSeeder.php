<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Fields\TitleFieldSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class ButtonBlockSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "label" field.
     *
     * @var string
     */
    public const LABEL = 'label';

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
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'button'))
        {
            return $block;
        }

        $LinkBlockSeeder = new LinkBlockSeeder()->run();
        $TitleFieldSeeder = new TitleFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $TitleFieldSeeder,
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
                $LinkBlockSeeder,
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
