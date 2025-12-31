<?php

namespace Narsil\Database\Seeders;

#region USE

use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldBlock;
use Narsil\Models\Structures\FieldOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ElementSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function saveBlock(Block $block): Block
    {
        $model = Block::query()
            ->where(Block::HANDLE, $block->{Block::HANDLE})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = Block::create([
            Block::HANDLE => $block->{Block::HANDLE},
            Block::NAME => $block->{Block::NAME},
        ]);

        if ($blockElements = $block->{Block::RELATION_ELEMENTS})
        {
            foreach ($blockElements as $position => $blockElement)
            {
                if ($element = $blockElement->{BlockElement::RELATION_ELEMENT})
                {
                    if ($element instanceof Field)
                    {
                        $element = $this->saveField($element);

                        BlockElement::create([
                            BlockElement::ELEMENT_ID => $element->{Field::ID},
                            BlockElement::ELEMENT_TYPE => Field::TABLE,
                            BlockElement::HANDLE => $blockElement->{BlockElement::HANDLE} ?? $element->{Field::HANDLE},
                            BlockElement::NAME => $element->{Field::NAME},
                            BlockElement::OWNER_ID => $model->{Block::ID},
                            BlockElement::POSITION => $position,
                            BlockElement::REQUIRED => $blockElement->{BlockElement::REQUIRED},
                            BlockElement::TRANSLATABLE => $blockElement->{BlockElement::TRANSLATABLE},
                            BlockElement::WIDTH => $blockElement->{BlockElement::WIDTH} ?? 100,
                        ]);
                    }
                    else if ($element instanceof Block)
                    {
                        $element = $this->saveBlock($element);

                        BlockElement::create([
                            BlockElement::ELEMENT_ID => $element->{Block::ID},
                            BlockElement::ELEMENT_TYPE => Block::TABLE,
                            BlockElement::HANDLE => $blockElement->{BlockElement::HANDLE} ?? $element->{Block::HANDLE},
                            BlockElement::NAME => $element->{Block::NAME},
                            BlockElement::OWNER_ID => $model->{Block::ID},
                            BlockElement::POSITION => $position,
                            BlockElement::REQUIRED => $blockElement->{BlockElement::REQUIRED},
                            BlockElement::TRANSLATABLE => $blockElement->{BlockElement::TRANSLATABLE},
                            BlockElement::WIDTH => $blockElement->{BlockElement::WIDTH} ?? 100,
                        ]);
                    }
                }
            }
        }

        return $model;
    }

    /**
     * {@inheritDoc}
     */
    protected function saveField(Field $field): Field
    {
        $model = Field::query()
            ->where(Field::HANDLE, $field->{Field::HANDLE})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = Field::create([
            Field::HANDLE => $field->{Field::HANDLE},
            Field::NAME => $field->{Field::NAME},
            Field::SETTINGS => $field->{Field::SETTINGS},
            Field::TRANSLATABLE => $field->{Field::TRANSLATABLE} ?? false,
            Field::TYPE => $field->{Field::TYPE},
        ]);

        if ($fieldBlocks = $field->{Field::RELATION_BLOCKS})
        {
            foreach ($fieldBlocks as $position => $fieldBlock)
            {
                $block = $this->saveBlock($fieldBlock);

                FieldBlock::create([
                    FieldBlock::BLOCK_ID => $block->{Block::ID},
                    FieldBlock::FIELD_ID => $model->{Field::ID},
                ]);
            }
        }

        if ($fieldOptions = $field->{Field::RELATION_OPTIONS})
        {
            foreach ($fieldOptions as $position => $fieldOption)
            {
                FieldOption::create([
                    FieldOption::FIELD_ID => $model->{Field::ID},
                    FieldOption::LABEL => $fieldOption->{FieldOption::LABEL},
                    FieldOption::POSITION => $position,
                    FieldOption::VALUE => $fieldOption->{FieldOption::VALUE},
                ]);
            }
        }

        return $model;
    }

    #endregion
}
