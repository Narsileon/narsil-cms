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
    #region CONSTANTS

    /**
     * The name of the "link" handle
     *
     * @var string
     */
    const LINK = 'link';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => self::LINK,
            Block::NAME => 'Link',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::LINK,
                        Field::NAME => 'Link',
                        Field::REQUIRED => true,
                        Field::TYPE => LinkField::class,
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
