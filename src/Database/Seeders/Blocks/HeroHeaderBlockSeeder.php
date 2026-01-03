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
     * The name of the "hero header" handle
     *
     * @var string
     */
    const HERO_HEADER = 'hero_header';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $headlineBlock = new HeadlineBlockSeeder()->block();

        return new Block([
            Block::HANDLE => self::HERO_HEADER,
            Block::NAME => 'Hero Header',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => $headlineBlock,
                ]),
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::EXCERPT,
                        Field::NAME => 'Excerpt',
                        Field::REQUIRED => true,
                        Field::TRANSLATABLE => true,
                        Field::TYPE => RichTextField::class,
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::BUTTONS,
                        Field::NAME => 'Buttons',
                        Field::TYPE => BuilderField::class,
                        Field::RELATION_BLOCKS => [
                            new ButtonBlockSeeder()->block(),
                        ],
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
