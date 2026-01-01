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
            Block::NAME => 'Headline',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::HEADLINE,
                        Field::NAME => 'Headline',
                        Field::REQUIRED => true,
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(SelectField::class),
                    ]),
                ]),
                new BlockElement([
                    BlockElement::WIDTH => 50,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::HEADLINE_LEVEL,
                        Field::NAME => 'Level',
                        Field::REQUIRED => true,
                        Field::TYPE => SelectField::class,
                        Field::RELATION_OPTIONS => $headlineSelectOptions,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('h1'),
                    ]),
                ]),
                new BlockElement([
                    BlockElement::WIDTH => 50,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::HEADLINE_STYLE,
                        Field::NAME => 'Style',
                        Field::REQUIRED => true,
                        Field::TYPE => SelectField::class,
                        Field::RELATION_OPTIONS => $headlineSelectOptions,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('h6'),
                    ]),
                ]),
            ],
        ]);
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
