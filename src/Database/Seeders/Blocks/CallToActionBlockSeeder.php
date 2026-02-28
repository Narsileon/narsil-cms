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
final class CallToActionBlockSeeder extends Seeder
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
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'call_to_action'))
        {
            return $block;
        }

        $LayoutBlockSeeder = new LayoutBlockSeeder()->run();
        $LinkBlockSeeder = new LinkBlockSeeder()->run();
        $TitleFieldSeeder = new TitleFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $LayoutBlockSeeder,
                [
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Layout',
                    BlockElement::POSITION => 0,
                ],
                Block::RELATION_BLOCKS
            )
            ->hasAttached(
                $TitleFieldSeeder,
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
                $LinkBlockSeeder,
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
