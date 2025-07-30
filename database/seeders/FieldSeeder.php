<?php

namespace Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Contracts\Fields\RichTextInput;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

class FieldSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        $contentBlock = $this->createContentBlock();
        $richTextBlock = $this->createRichTextBlock();

        $contentBlock->Blocks()->attach($richTextBlock->{Field::ID}, [
            BlockElement::POSITION => 0,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return Block
     */
    protected function createContentBlock(): Block
    {
        $contentBlock = Block::create([
            Block::NAME => 'Content',
            Block::HANDLE => 'content',
        ]);

        return $contentBlock;
    }

    /**
     * @return Block
     */
    protected function createRichTextBlock(): Block
    {
        $richTextField = Field::create([
            Field::NAME => 'Rich text',
            Field::HANDLE => 'rich_text',
            Field::SETTINGS => app(RichTextInput::class)->toArray(),
        ]);

        $richTextBlock = Block::create([
            Block::NAME => 'Rich text',
            Block::HANDLE => 'rich_text',
        ]);

        $richTextBlock->fields()->attach($richTextField->{Field::ID}, [
            BlockElement::POSITION => 0,
        ]);

        return $richTextBlock;
    }

    #endregion
}
