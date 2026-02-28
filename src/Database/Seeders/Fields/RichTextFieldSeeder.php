<?php

namespace Narsil\Cms\Database\Seeders\Fields;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Base\Http\Data\Forms\Inputs\RichTextInputData;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class RichTextFieldSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public function run(): Field
    {
        if ($field = Field::firstWhere(Field::HANDLE, 'rich_text'))
        {
            return $field;
        }

        return Field::factory()
            ->create([
                Field::HANDLE => 'rich_text',
                Field::LABEL => 'Rich text',
                Field::TYPE => RichTextInputData::TYPE,
            ]);
    }

    #endregion
}
