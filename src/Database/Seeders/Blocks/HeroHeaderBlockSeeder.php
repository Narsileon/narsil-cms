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
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $headlineBlock = new HeadlineBlockSeeder()->block();

        return new Block([
            Block::HANDLE => 'hero_header',
            Block::NAME => 'Hero Header',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => $headlineBlock,
                ]),
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'excerpt',
                        Field::NAME => 'Excerpt',
                        Field::TRANSLATABLE => true,
                        Field::TYPE => RichTextField::class,
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'hero_header_buttons',
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
