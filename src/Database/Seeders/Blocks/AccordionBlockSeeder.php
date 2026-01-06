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
    #region CONSTANTS

    /**
     * The name of the "accordion" handle
     *
     * @var string
     */
    const ACCORDION = 'accordion';

    /**
     * The name of the "accordion builder" handle
     *
     * @var string
     */
    const ACCORDION_BUILDER = 'accordion_builder';

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
        return new Block([
            Block::HANDLE => self::ACCORDION,
            Block::LABEL => 'Accordion',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::ACCORDION_BUILDER,
                        Field::LABEL => 'Items',
                        Field::TYPE => BuilderField::class,
                        Field::RELATION_BLOCKS => [
                            new Block([
                                Block::HANDLE => self::ACCORDION_ITEM,
                                Block::LABEL => 'Accordion Item',
                                Block::RELATION_ELEMENTS => [
                                    new BlockElement([
                                        BlockElement::REQUIRED => true,
                                        BlockElement::TRANSLATABLE => true,
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => self::ACCORDION_ITEM_TRIGGER,
                                            Field::LABEL => 'Trigger',
                                            Field::REQUIRED => true,
                                            Field::TRANSLATABLE => true,
                                            Field::TYPE => TextField::class,
                                            Field::RELATION_BLOCKS => []
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::REQUIRED => true,
                                        BlockElement::TRANSLATABLE => true,
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => self::ACCORDION_ITEM_CONTENT,
                                            Field::LABEL => 'Content',
                                            Field::REQUIRED => true,
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
