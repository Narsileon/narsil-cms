<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\LinkField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LinkBlockSeeder extends BlockSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => 'link',
            Block::NAME => 'Link',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'link',
                        Field::NAME => 'Link',
                        Field::TYPE => LinkField::class,
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
