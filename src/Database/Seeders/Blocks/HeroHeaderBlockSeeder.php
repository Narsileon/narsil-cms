<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\BuilderField;
use Narsil\Contracts\Fields\RichTextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeroHeaderBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "buttons" handle
     *
     * @var string
     */
    const BUTTONS = 'buttons';

    /**
     * The name of the "excerpt" handle
     *
     * @var string
     */
    const EXCERPT = 'excerpt';

    /**
     * The name of the "headline" handle
     *
     * @var string
     */
    const HEADLINE = 'headline';

    /**
     * The name of the "hero header" handle
     *
     * @var string
     */
    const HERO_HEADER = 'hero_header';

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
        $buttonBlock = new ButtonBlockSeeder()->block();
        $headlineBlock = new HeadlineBlockSeeder()->block();
        $layoutBlock = new LayoutBlockSeeder()->block();

        return new Block([
            Block::HANDLE => self::HERO_HEADER,
            Block::LABEL => 'Hero Header',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Padding',
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    $layoutBlock,
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::HEADLINE,
                    BlockElement::LABEL => 'Headline',
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    $headlineBlock,
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::EXCERPT,
                    BlockElement::LABEL => 'Excerpt',
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => RichTextField::class,
                    ]),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::BUTTONS,
                    BlockElement::LABEL => 'Buttons',
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => BuilderField::class,
                    ])->setRelation(
                        Field::RELATION_BLOCKS,
                        [
                            $buttonBlock,
                        ],
                    ),
                ),
            ],
        );
    }

    #endregion
}
