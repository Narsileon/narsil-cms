<?php

namespace Narsil\Cms\Database\Factories\Fields;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TitleField
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public static function run(): Field
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
