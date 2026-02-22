<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Narsil\Base\Enums\InputTypeEnum;
use Narsil\Cms\Database\Seeders\BlockSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

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
                    BlockElement::RELATION_BASE,
                    new Field([
                        Field::TYPE => InputTypeEnum::TEXT,
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
