<?php

namespace Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Contracts\Fields\Text\RichTextField;
use Narsil\Models\Fields\Field;
use Narsil\Models\Fields\FieldSet;
use Narsil\Models\Fields\FieldSetItem;

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

        $contentFieldSet->fieldSets()->attach($richTextFieldSet->{Field::ID}, [
            FieldSetItem::POSITION => 0,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return FieldSet
     */
    protected function createContentFieldSet(): FieldSet
    {
        $contentFieldSet = FieldSet::create([
            FieldSet::NAME => 'Content',
            FieldSet::HANDLE => 'content',
        ]);

        return $contentFieldSet;
    }

    /**
     * @return FieldSet
     */
    protected function createRichTextFieldSet(): FieldSet
    {
        $richTextField = Field::create([
            Field::NAME => 'Rich text',
            Field::HANDLE => 'rich_text',
            Field::SETTINGS => app(RichTextField::class)->toArray(),
        ]);

        $richTextFieldSet = FieldSet::create([
            FieldSet::NAME => 'Rich text',
            FieldSet::HANDLE => 'rich_text',
        ]);

        $richTextFieldSet->fields()->attach($richTextField->{Field::ID}, [
            FieldSetItem::POSITION => 0,
        ]);

        return $richTextFieldSet;
    }

    #endregion
}
