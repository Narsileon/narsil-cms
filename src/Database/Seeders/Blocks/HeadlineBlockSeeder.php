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
class HeadlineBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "headline" handle
     *
     * @var string
     */
    const HEADLINE = 'headline';

    /**
     * The name of the "headline level" handle
     *
     * @var string
     */
    const HEADLINE_LEVEL = 'headline_level';

    /**
     * The name of the "headline style" handle
     *
     * @var string
     */
    const HEADLINE_STYLE = 'headline_style';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $headlineSelectOptions = $this->getHeadlineSelectOptions();

        return new Block([
            Block::HANDLE => self::HEADLINE,
            Block::LABEL => 'Headline',
        ])->setRelation(
            Block::RELATION_ELEMENTS,
            [
                new BlockElement([
                    BlockElement::HANDLE => self::HEADLINE,
                    BlockElement::LABEL => 'Headline',
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(SelectField::class),
                    ]),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::HEADLINE_LEVEL,
                    BlockElement::LABEL => 'Level',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('h1'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        $headlineSelectOptions,
                    ),
                ),
                new BlockElement([
                    BlockElement::HANDLE => self::HEADLINE_STYLE,
                    BlockElement::LABEL => 'Style',
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50,
                ])->setRelation(
                    BlockElement::RELATION_ELEMENT,
                    new Field([
                        Field::TYPE => SelectField::class,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('h6'),
                    ])->setRelation(
                        Field::RELATION_OPTIONS,
                        $headlineSelectOptions,
                    ),
                ),
            ],
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the headlines as field options.
     *
     * @return array<FieldOption>
     */
    protected function getHeadlineSelectOptions(): array
    {
        $headlines = [
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
        ];

        $options = [];

        foreach ($headlines as $headline)
        {
            $options[] = new FieldOption([
                FieldOption::LABEL => $headline,
                FieldOption::VALUE => $headline,
            ]);
        }

        return $options;
    }

    #endregion
}
