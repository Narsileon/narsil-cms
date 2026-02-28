<?php

namespace Narsil\Cms\Database\Seeders\Fields;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class TitleFieldSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public function run(): Field
    {
        if ($field = Field::firstWhere(Field::HANDLE, 'title'))
        {
            return $field;
        }

        return Field::factory()
            ->create([
                Field::HANDLE => 'title',
                Field::LABEL => 'Title',
                Field::TYPE => TextInputData::TYPE,
            ]);
    }

    #endregion
}
