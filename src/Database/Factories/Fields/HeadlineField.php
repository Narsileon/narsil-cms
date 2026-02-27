<?php

namespace Narsil\Cms\Database\Factories\Fields;

#region USE

use Illuminate\Database\Eloquent\Factories\Sequence;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class HeadlineField
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public static function run(): Field
    {
        if ($field = Field::firstWhere(Field::HANDLE, 'headline'))
        {
            return $field;
        }

        return Field::factory()
            ->has(
                FieldOption::factory()
                    ->count(6)
                    ->sequence(
                        [
                            FieldOption::LABEL => 'H1',
                            FieldOption::VALUE => 'h1',
                        ],
                        [
                            FieldOption::LABEL => 'H2',
                            FieldOption::VALUE => 'h2',
                        ],
                        [
                            FieldOption::LABEL => 'H3',
                            FieldOption::VALUE => 'h3',
                        ],
                        [
                            FieldOption::LABEL => 'H4',
                            FieldOption::VALUE => 'h4',
                        ],
                        [
                            FieldOption::LABEL => 'H5',
                            FieldOption::VALUE => 'h5',
                        ],
                        [
                            FieldOption::LABEL => 'H6',
                            FieldOption::VALUE => 'h6',
                        ]
                    )
                    ->state(new Sequence(function (Sequence $sequence)
                    {
                        return [
                            FieldOption::POSITION => $sequence->index,
                        ];
                    })),
                Field::RELATION_OPTIONS
            )
            ->create([
                Field::HANDLE => 'headline',
                Field::LABEL => 'Headline',
                Field::TYPE => SelectInputData::TYPE,
                Field::SETTINGS => [
                    SelectInputData::DEFAULT_VALUE => 'h4',
                ],
            ]);
    }

    #endregion
}
