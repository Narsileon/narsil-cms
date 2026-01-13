<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\BuilderField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;

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
     * The name of the "layout" handle
     *
     * @var string
     */
    const LAYOUT = 'layout';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $accordionItemBlock = new AccordionItemBlockSeeder()->block();
        $layoutBlock = new LayoutBlockSeeder()->block();

        return new Block([
            Block::HANDLE => self::ACCORDION,
            Block::LABEL => 'Accordion',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Layout',
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    $layoutBlock,
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::ACCORDION_BUILDER,
                    BlockElement::LABEL => 'Items',
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    new Field([
                        Field::TYPE => BuilderField::class,
                    ])->setRelation(
                        Field::RELATION_BLOCKS,
                        [
                            $accordionItemBlock,
                        ],
                    ),
                ),
            ],
        );
    }

    #endregion
}
