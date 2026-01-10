<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\SelectField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LayoutBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "layout" handle
     *
     * @var string
     */
    const LAYOUT = 'layout';

    /**
     * The name of the "padding" handle
     *
     * @var string
     */
    const PADDING = 'padding';

    /**
     * The name of the "size" handle
     *
     * @var string
     */
    const SIZE = 'size';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $paddingBlock = new PaddingBlockSeeder()->block();

        $sizeFieldOptions = $this->sizeFieldOptions();

        return new Block([
            Block::COLLAPSIBLE => true,
            Block::HANDLE => self::LAYOUT,
            Block::LABEL => 'Layout',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::SIZE,
                    BlockElement::LABEL => 'Size',
                    BlockElement::REQUIRED => true,
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    new Field([
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('md'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        $sizeFieldOptions,
                    ),
                ),
                new BlockElement([
                    BlockElement::HANDLE => PaddingBlockSeeder::PADDING,
                    BlockElement::LABEL => 'Padding',
                ])->setRelation(
                    BlockElement::RELATION_BASE,
                    $paddingBlock,
                ),
            ],
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the size field options.
     *
     * @return array<FieldOption>
     */
    protected function sizeFieldOptions(): array
    {
        return [
            new FieldOption([
                FieldOption::LABEL => "Small",
                FieldOption::VALUE => "sm",
            ]),
            new FieldOption([
                FieldOption::LABEL => "Medium",
                FieldOption::VALUE => "md",
            ]),
            new FieldOption([
                FieldOption::LABEL => "Large",
                FieldOption::VALUE => "lg",
            ]),
        ];
    }

    #endregion
}
