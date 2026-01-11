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
class CallToActionBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "label" handle
     *
     * @var string
     */
    const LABEL = 'label';

    /**
     * The name of the "layout" handle
     *
     * @var string
     */
    const LAYOUT = 'layout';

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
        $layoutBlock = new LayoutBlockSeeder()->block();
        $linkBlock = new LinkBlockSeeder()->block();

        return new Block([
            Block::HANDLE => 'call_to_action',
            Block::LABEL => 'Call to action',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Padding',
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    $layoutBlock,
                ),
                new BlockElement([
                    BlockElement::HANDLE => 'label',
                    BlockElement::LABEL => 'Label',
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    new Field([
                        Field::TYPE => TextField::class,
                    ]),
                ),
                new BlockElement([
                    BlockElement::HANDLE => 'link',
                    BlockElement::LABEL => 'Link',
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    $linkBlock,
                ),
            ],
        );
    }

    #endregion
}
