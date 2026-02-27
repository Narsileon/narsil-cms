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
abstract class PaddingField
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public static function run(): Field
    {
        if ($field = Field::firstWhere(Field::HANDLE, 'padding'))
        {
            return $field;
        }

        return Field::factory()
            ->has(
                FieldOption::factory()
                    ->count(5)
                    ->sequence(
                        [
                            FieldOption::LABEL => 'None',
                            FieldOption::VALUE => 'none'
                        ],
                        [
                            FieldOption::LABEL => 'Extra Small',
                            FieldOption::VALUE => 'xs'
                        ],
                        [
                            FieldOption::LABEL => 'Small',
                            FieldOption::VALUE => 'sm'
                        ],
                        [
                            FieldOption::LABEL => 'Medium',
                            FieldOption::VALUE => 'md'
                        ],
                        [
                            FieldOption::LABEL => 'Large',
                            FieldOption::VALUE => 'lg'
                        ],
                        [
                            FieldOption::LABEL => 'Extra Large',
                            FieldOption::VALUE => 'xl'
                        ],
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
                Field::HANDLE => 'padding',
                Field::LABEL => 'Padding',
                Field::TYPE => SelectInputData::TYPE,
                Field::SETTINGS => [
                    SelectInputData::DEFAULT_VALUE => 'none',
                ],
            ]);
    }

    #endregion
}
