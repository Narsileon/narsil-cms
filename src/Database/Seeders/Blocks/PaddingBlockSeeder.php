<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PaddingBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "bottom" handle
     *
     * @var string
     */
    const BOTTOM = 'bottom';

    /**
     * The name of the "padding" handle
     *
     * @var string
     */
    const PADDING = 'padding';

    /**
     * The name of the "top" handle
     *
     * @var string
     */
    const TOP = 'top';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $paddingFieldOptions = $this->paddingFieldOptions();

        return new Block([
            Block::COLLAPSIBLE => true,
            Block::HANDLE => self::PADDING,
            Block::LABEL => 'Padding',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::TOP,
                    BlockElement::LABEL => 'Top',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::HANDLE => self::PADDING,
                        Field::LABEL => "Padding",
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('none'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        $paddingFieldOptions,
                    ),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::BOTTOM,
                    BlockElement::LABEL => 'Bottom',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::HANDLE => self::PADDING,
                        Field::LABEL => "Padding",
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('none'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        $paddingFieldOptions,
                    ),
                ),
            ],
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the padding field options.
     *
     * @return array<FieldOption>
     */
    protected function paddingFieldOptions(): array
    {
        return [
            new FieldOption([
                FieldOption::LABEL => "None",
                FieldOption::VALUE => "none",
            ]),
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
