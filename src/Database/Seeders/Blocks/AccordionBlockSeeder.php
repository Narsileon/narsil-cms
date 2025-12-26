<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\BuilderField;
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
class AccordionBlockSeeder extends BlockSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => 'accordion',
            Block::NAME => 'Accordion',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'accordion_builder',
                        Field::NAME => 'Items',
                        Field::TYPE => BuilderField::class,
                        Field::RELATION_BLOCKS => [
                            new Block([
                                Block::HANDLE => 'accordion_item',
                                Block::NAME => 'Accordion Item',
                                Block::RELATION_ELEMENTS => [
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => 'accordion_item_trigger',
                                            Field::NAME => 'Trigger',
                                            Field::TRANSLATABLE => true,
                                            Field::TYPE => TextField::class,
                                            Field::RELATION_BLOCKS => []
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => 'accordion_item_content',
                                            Field::NAME => 'Content',
                                            Field::TRANSLATABLE => true,
                                            Field::TYPE => RichTextField::class,
                                        ]),
                                    ]),
                                ],
                            ]),
                        ],
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
