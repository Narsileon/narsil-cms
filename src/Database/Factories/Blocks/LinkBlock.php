<?php

namespace Narsil\Cms\Database\Factories\Blocks;

#region USE

use Narsil\Base\Enums\OperatorEnum;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Cms\Http\Data\Forms\Inputs\LinkInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\BlockElementCondition;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class LinkBlock
{
    #region CONSTANTS

    /**
     * The name of the "page" block.
     *
     * @var string
     */
    public const PAGE = 'page';

    /**
     * The name of the "type" field.
     *
     * @var string
     */
    public const TYPE = 'type';

    /**
     * The name of the "url" field.
     *
     * @var string
     */
    public const URL = 'url';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'link'))
        {
            return $block;
        }

        return Block::factory()
            ->hasAttached(
                Field::factory()->state([
                    Field::HANDLE => 'link_type',
                    Field::LABEL => 'Link Type',
                    FIeld::TYPE => SelectInputData::TYPE,
                ])->has(
                    FieldOption::factory()
                        ->count(2)
                        ->sequence(
                            [
                                FieldOption::LABEL => 'Internal',
                                FieldOption::POSITION => 0,
                                FieldOption::VALUE => 'internal',
                            ],
                            [
                                FieldOption::LABEL => 'External',
                                FieldOption::POSITION => 1,
                                FieldOption::VALUE => 'external',
                            ],
                        ),
                    Field::RELATION_OPTIONS
                ),
                [
                    BlockElement::HANDLE => self::TYPE,
                    BlockElement::LABEL => 'Type',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 25,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                Field::factory()->state([
                    Field::HANDLE => 'page',
                    Field::LABEL => 'Page',
                    Field::TYPE => LinkInputData::TYPE,
                ]),
                [
                    BlockElement::HANDLE => self::PAGE,
                    BlockElement::LABEL  => 'Page',
                    BlockElement::POSITION => 1,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 75
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                Field::factory()->state([
                    Field::HANDLE => 'url',
                    Field::LABEL => 'URL',
                    Field::TYPE => TextInputData::TYPE,
                ]),
                [
                    BlockElement::HANDLE => self::URL,
                    BlockElement::LABEL  => 'URL',
                    BlockElement::POSITION => 2,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 75
                ],
                Block::RELATION_FIELDS
            )
            ->afterCreating(function (Block $block)
            {
                foreach ($block->{Block::RELATION_ELEMENTS} as $element)
                {
                    match ($element->{BlockElement::HANDLE})
                    {
                        'page' => $element->conditions()->create([
                            BlockElementCondition::HANDLE => 'type',
                            BlockElementCondition::OPERATOR => OperatorEnum::EQUALS->value,
                            BlockElementCondition::VALUE => 'internal',
                        ]),
                        'url' => $element->conditions()->create([
                            BlockElementCondition::HANDLE => 'type',
                            BlockElementCondition::OPERATOR => OperatorEnum::EQUALS->value,
                            BlockElementCondition::VALUE => 'external',
                        ]),
                        default => null,
                    };
                }
            })
            ->create([
                Block::HANDLE => 'link',
                Block::LABEL => 'Link',
            ]);
    }

    #endregion
}
