<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\LinkField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\BlockElementCondition;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;

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

    /**
     * The name of the "type" handle
     *
     * @var string
     */
    const TYPE = 'type';

    /**
     * The name of the "url" handle
     *
     * @var string
     */
    const URL = 'url';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => self::LINK,
            Block::LABEL => 'Link',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::TYPE,
                    BlockElement::LABEL => 'Type',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 25,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('internal'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        [
                            new FieldOption([
                                FieldOption::LABEL => 'Internal',
                                FieldOption::VALUE => 'internal',
                            ]),
                            new FieldOption([
                                FieldOption::LABEL => 'External',
                                FieldOption::VALUE => 'external',
                            ]),
                        ],
                    ),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::LINK,
                    BlockElement::LABEL => 'Page',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 75,
                ])->setRelation(
                    BlockElement::RELATION_CONDITIONS,
                    [
                        new BlockElementCondition([
                            BlockElementCondition::HANDLE => self::TYPE,
                            BlockElementCondition::OPERATOR => '=',
                            BlockElementCondition::VALUE => 'internal',
                        ]),
                    ],
                )->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => LinkField::class,
                    ]),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::URL,
                    BlockElement::LABEL => 'URL',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 75,
                ])->setRelation(
                    BlockElement::RELATION_CONDITIONS,
                    [
                        new BlockElementCondition([
                            BlockElementCondition::HANDLE => self::TYPE,
                            BlockElementCondition::OPERATOR => '=',
                            BlockElementCondition::VALUE => 'external',
                        ]),
                    ],
                )->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => TextField::class,
                    ]),
                ),
            ],
        );
    }

    #endregion
}
