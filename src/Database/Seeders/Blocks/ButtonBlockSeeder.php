<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;

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
        $linkBlock = new LinkBlockSeeder()->block();

        return new Block([
            Block::HANDLE => 'button',
            Block::LABEL => 'Button',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => 'label',
                    BlockElement::LABEL => 'Label',
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => TextField::class,
                    ]),
                ),
                new BlockElement([
                    BlockElement::HANDLE => 'link',
                    BlockElement::LABEL => 'Link',
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    $linkBlock,
                ),
            ],
        );
    }

    #endregion
}
