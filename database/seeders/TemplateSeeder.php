<?php

namespace Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Contracts\Fields\BuilderElement;
use Narsil\Contracts\Fields\RichTextInput;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\FieldBlock;

#endregion

class TemplateSeeder extends Seeder
{
    #region PUBLIC METHODS

    /**
     * @return void
     */
    public function run(): void
    {
        // Blocks
        $richTextBlock = $this->createRichTextBlock();

        // Fields
        $builderField = $this->createBuilderField();

        FieldBlock::create([
            FieldBlock::BLOCK_ID => $richTextBlock->{Block::ID},
            FieldBlock::FIELD_ID => $builderField->{Field::ID},
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
     * @return Field
     */
    protected function createBuilderField(): Field
    {
        $field = Field::create([
            Field::NAME => 'Builder',
            Field::HANDLE => 'builder',
            Field::TYPE => BuilderElement::class,
            Field::SETTINGS => app(BuilderElement::class),
        ]);

        return $field;
    }

    /**
     * @return Block
     */
    protected function createRichTextBlock(): Block
    {
        $field = Field::create([
            Field::NAME => 'Rich text',
            Field::HANDLE => 'rich_text',
            Field::TYPE => RichTextInput::class,
            Field::SETTINGS => app(RichTextInput::class),
        ]);

        $block = Block::create([
            Block::NAME => 'Rich text',
            Block::HANDLE => 'rich_text',
        ]);

        $block->fields()->attach($field->{Field::ID}, [
            BlockElement::HANDLE => $field->{Field::HANDLE},
            BlockElement::NAME => $field->{Field::NAME},
            BlockElement::POSITION => 0,
        ]);

        return $block;
    }

    #endregion
}
