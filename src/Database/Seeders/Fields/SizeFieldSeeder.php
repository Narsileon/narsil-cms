<?php

namespace Narsil\Cms\Database\Seeders\Fields;

#region USE

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class SizeFieldSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public function run(): Field
    {
        if ($field = Field::firstWhere(Field::HANDLE, 'size'))
        {
            return $field;
        }

        return Field::factory()
            ->has(
                FieldOption::factory()
                    ->count(3)
                    ->sequence(
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
                Field::HANDLE => 'size',
                Field::LABEL => 'Size',
                Field::TYPE => SelectInputData::TYPE,
                Field::SETTINGS => [
                    SelectInputData::DEFAULT_VALUE => 'md',
                ],
            ]);
    }

    #endregion
}
