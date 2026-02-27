<?php

namespace Narsil\Cms\Database\Factories\Fields;

#region USE

use Narsil\Base\Http\Data\Forms\Inputs\RichTextInputData;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class RichTextField
{
    #region PUBLIC METHODS

    /**
     * @return Field
     */
    public static function run(): Field
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
