<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Fields\RichTextFieldSeeder;
use Narsil\Cms\Database\Seeders\Fields\TitleFieldSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class AccordionItemBlockSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "content" field.
     *
     * @var string
     */
    public const CONTENT = 'content';

    /**
     * The name of the "trigger" block.
     *
     * @var string
     */
    public const TRIGGER = 'trigger';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'accordion_item'))
        {
            return $block;
        }

        $TitleFieldSeeder = new TitleFieldSeeder()->run();
        $RichTextFieldSeeder = new RichTextFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $TitleFieldSeeder,
                [
                    BlockElement::HANDLE => self::TRIGGER,
                    BlockElement::LABEL => 'Trigger',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $RichTextFieldSeeder,
                [
                    BlockElement::HANDLE => self::CONTENT,
                    BlockElement::LABEL  => 'Content',
                    BlockElement::POSITION => 1,
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ],
                Block::RELATION_FIELDS
            )
            ->create([
                Block::HANDLE => 'accordion_item',
                Block::LABEL => 'Accordion Item',
            ]);
    }

    #endregion
}
