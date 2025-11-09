<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

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
        return new Block([
            Block::HANDLE => 'hero-header',
            Block::NAME => 'Hero Header',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'headline',
                        Field::NAME => 'Headline',
                        Field::TYPE => TextField::class,
                        Field::RELATION_BLOCKS => []
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'excerpt',
                        Field::NAME => 'Excerpt',
                        Field::TYPE => RichTextField::class,
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'url',
                        Field::NAME => 'URL',
                        Field::TYPE => TextField::class,
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
