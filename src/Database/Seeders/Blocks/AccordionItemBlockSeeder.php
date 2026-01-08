<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class AccordionItemBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "accordion item" handle
     *
     * @var string
     */
    const ACCORDION_ITEM = 'accordion_item';

    /**
     * The name of the "accordion item content" handle
     *
     * @var string
     */
    const ACCORDION_ITEM_CONTENT = 'accordion_item_content';

    /**
     * The name of the "accordion item trigger" handle
     *
     * @var string
     */
    const ACCORDION_ITEM_TRIGGER = 'accordion_item_trigger';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return
            new Block([
                Block::HANDLE => self::ACCORDION_ITEM,
                Block::LABEL => 'Accordion Item',
            ])->setRelation(
                Block::RELATION_ELEMENTS,
                [
                    new BlockElement([
                        BlockElement::HANDLE => self::ACCORDION_ITEM_TRIGGER,
                        BlockElement::LABEL => 'Trigger',
                        BlockElement::REQUIRED => true,
                        BlockElement::TRANSLATABLE => true,
                    ])->setRelation(
                        BlockElement::RELATION_ELEMENT,
                        new Field([
                            Field::TYPE => TextField::class,
                        ]),
                    ),
                    new BlockElement([
                        BlockElement::HANDLE => self::ACCORDION_ITEM_CONTENT,
                        BlockElement::LABEL => 'Content',
                        BlockElement::REQUIRED => true,
                        BlockElement::TRANSLATABLE => true,
                    ])->setRelation(
                        BlockElement::RELATION_ELEMENT,
                        new Field([
                            Field::TYPE => RichTextField::class,
                        ]),
                    ),
                ],
            );
    }

    #endregion
}
