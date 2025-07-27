<?php

namespace Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Contracts\Fields\Text\RichTextField;
use Narsil\Enums\Fields\FieldTypeEnum;
use Narsil\Models\Fields\Field;

#endregion

class FieldSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        $contentFieldSet = $this->createContentFieldSet();
        $richTextFieldSet = $this->createRichTextFieldSet();

        $contentFieldSet->sets()->attach($richTextFieldSet->{Field::ID});
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Field
     */
    protected function createContentFieldSet(): Field
    {
        $contentFieldSet = Field::create([
            Field::NAME => 'Content',
            Field::HANDLE => 'content',
            Field::TYPE => FieldTypeEnum::FIELD_SET->value,
        ]);

        return $contentFieldSet;
    }

    /**
     * @return Field
     */
    protected function createRichTextFieldSet(): Field
    {
        $richTextFieldSet = Field::create([
            Field::NAME => 'Rich text',
            Field::HANDLE => 'rich_text',
            Field::TYPE => FieldTypeEnum::FIELD_SET->value,
        ]);

        Field::create([
            Field::NAME => 'Rich text',
            Field::HANDLE => 'rich_text',
            Field::PARENT_ID => $richTextFieldSet->{Field::ID},
            Field::TYPE => FieldTypeEnum::FIELD->value,
            Field::SETTINGS => app(RichTextField::class)->toArray(),
        ]);

        return $richTextFieldSet;
    }

    #endregion
}
