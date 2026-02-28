<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class AccordionBlockSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "items" field.
     *
     * @var string
     */
    public const ITEMS = 'items';

    /**
     * The name of the "layout" block.
     *
     * @var string
     */
    public const LAYOUT = 'layout';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'accordion'))
        {
            return $block;
        }

        $AccordionItemBlockSeeder = new AccordionItemBlockSeeder()->run();
        $LayoutBlockSeeder = new LayoutBlockSeeder()->run();

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
                Field::factory()->state([
                    Field::HANDLE => 'accordion_builder',
                    Field::LABEL => 'Accordion Builder',
                    Field::TYPE => BuilderInputData::TYPE,
                ])->hasAttached(
                    $AccordionItemBlockSeeder,
                    [],
                    Field::RELATION_BLOCKS
                ),
                [
                    BlockElement::HANDLE => self::ITEMS,
                    BlockElement::LABEL  => 'Items',
                    BlockElement::POSITION => 1,
                ],
                Block::RELATION_FIELDS
            )
            ->create([
                Block::HANDLE => 'accordion',
                Block::LABEL => 'Accordion',
            ]);
    }

    #endregion
}
