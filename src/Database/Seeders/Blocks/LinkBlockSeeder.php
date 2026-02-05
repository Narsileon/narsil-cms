<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Narsil\Cms\Contracts\Fields\LinkField;
use Narsil\Cms\Contracts\Fields\SelectField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Database\Seeders\BlockSeeder;
use Narsil\Cms\Enums\Database\OperatorEnum;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;
use Narsil\Cms\Support\Models\ConditionData;

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
                    BlockElement::RELATION_BASE,
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
                        new ConditionData(
                            handle: self::TYPE,
                            operator: OperatorEnum::EQUALS->value,
                            value: 'internal',
                        )->toArray(),
                    ],
                )->setRelation(
                    BlockElement::RELATION_BASE,
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
                        new ConditionData(
                            handle: self::TYPE,
                            operator: OperatorEnum::EQUALS->value,
                            value: 'external',
                        )->toArray(),
                    ],
                )->setRelation(
                    BlockElement::RELATION_BASE,
                    new Field([
                        Field::TYPE => TextField::class,
                    ]),
                ),
            ],
        );
    }

    #endregion
}
