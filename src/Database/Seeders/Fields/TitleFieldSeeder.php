<?php

namespace Narsil\Database\Seeders\Fields;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\FieldSeeder;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TitleFieldSeeder extends FieldSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function field(): Field
    {
        return new Field([
            Field::HANDLE => 'title',
            Field::NAME => 'Title',
            Field::REQUIRED => true,
            Field::TRANSLATABLE => true,
            Field::TYPE => TextField::class,
            Field::SETTINGS => app(TextField::class),
        ]);
    }

    #endregion
}
