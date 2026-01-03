<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

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
class ButtonBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "label" handle
     *
     * @var string
     */
    const LABEL = 'label';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $linkBlock = new LinkBlockSeeder()->block();

        return new Block([
            Block::HANDLE => 'button',
            Block::NAME => 'Button',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'label',
                        Field::NAME => 'Label',
                        Field::REQUIRED => true,
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                    ]),
                ]),
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => $linkBlock,
                ]),
            ],
        ]);
    }

    #endregion
}
