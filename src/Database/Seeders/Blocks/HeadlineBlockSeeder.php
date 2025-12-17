<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeadlineBlockSeeder extends BlockSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        $headlineOptions = $this->getHeadlineOptions();

        return new Block([
            Block::HANDLE => 'headline',
            Block::NAME => 'Headline',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'headline',
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
                        Field::HANDLE => 'headline_level',
                        Field::NAME => 'Level',
                        Field::REQUIRED => true,
                        Field::TYPE => SelectField::class,
                        Field::RELATION_OPTIONS => $headlineOptions,
                        Field::SETTINGS => app(SelectField::class)
                            ->defaultValue('h1'),
                    ]),
                ]),
                new BlockElement([
                    BlockElement::WIDTH => 50,
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => 'headline_style',
                        Field::NAME => 'Style',
                        Field::REQUIRED => true,
                        Field::TYPE => SelectField::class,
                        Field::RELATION_OPTIONS => $headlineOptions,
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
     * Get the headline select options.
     *
     * @return array<FieldOption>
     */
    protected function getHeadlineOptions(): array
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
