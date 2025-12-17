<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

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
class ButtonBlockSeeder extends BlockSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => 'button',
            Block::NAME => 'Button',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'label',
                        Field::NAME => 'Label',
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::RELATION_BLOCKS => []
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'url',
                        Field::NAME => 'URL',
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
