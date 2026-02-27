<?php

namespace Narsil\Cms\Database\Factories\Blocks;

#region USE

use Narsil\Cms\Database\Factories\Fields\RichTextField;
use Narsil\Cms\Database\Factories\Fields\TitleField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AccordionItemBlock
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
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'accordion_item'))
        {
            return $block;
        }

        $titleField = TitleField::run();
        $richTextField = RichTextField::run();

        return Block::factory()
            ->hasAttached(
                $titleField,
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
                $richTextField,
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
