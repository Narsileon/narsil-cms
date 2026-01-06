<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\FieldBlock;
use Narsil\Models\Structures\FieldOption;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class StructuresSeeder extends Seeder
{
    #region PROTECTED METHODS

    /**
     * @param Block $block
     *
     * @return Block
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

        $blockElements = $block->{Block::RELATION_ELEMENTS} ?? [];

        foreach ($blockElements as $position => $blockElement)
        {
            $element = $blockElement->{BlockElement::RELATION_ELEMENT};

            if (!$element)
            {
                continue;
            }

            if ($element instanceof Field)
            {
                $element = $this->saveField($element);
            }
            else if ($element instanceof Block)
            {
                $element = $this->saveBlock($element);
            }

            BlockElement::create([
                BlockElement::ELEMENT_ID => $element->getKey(),
                BlockElement::ELEMENT_TYPE => $element->getTable(),
                BlockElement::HANDLE => $blockElement->{BlockElement::HANDLE} ?? $element->{BlockElement::HANDLE},
                BlockElement::NAME => $element->{BlockElement::NAME},
                BlockElement::OWNER_ID => $model->getKey(),
                BlockElement::POSITION => $position,
                BlockElement::REQUIRED => $blockElement->{BlockElement::REQUIRED} ?? $element->{BlockElement::REQUIRED} ?? false,
                BlockElement::TRANSLATABLE => $blockElement->{BlockElement::TRANSLATABLE} ?? $element->{BlockElement::TRANSLATABLE} ?? false,
                BlockElement::WIDTH => $blockElement->{BlockElement::WIDTH} ?? 100,
            ]);
        }

        return $model;
    }

    /**
     * @param Field $field
     *
     * @return Field
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
            Field::REQUIRED => $field->{Field::REQUIRED} ?? false,
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

    /**
     * @param Template $template
     *
     * @return Template
     */
    protected function saveTemplate(Template $template): Template
    {
        $templateModel = Template::query()
            ->where(Template::TABLE_NAME, $template->{Template::TABLE_NAME})
            ->first();

        if ($templateModel)
        {
            return $templateModel;
        }

        $templateModel = Template::create([
            Template::TABLE_NAME => $template->{Template::TABLE_NAME},
            Template::PLURAL => $template->{Template::PLURAL},
            Template::SINGULAR => $template->{Template::SINGULAR},
        ]);

        $templateTabs = $template->{Template::RELATION_TABS} ?? [];

        foreach ($templateTabs as $position => $templateTab)
        {
            $templateTabModel = TemplateTab::query()
                ->where(TemplateTab::TEMPLATE_ID, $templateModel->{Template::ID})
                ->where(TemplateTab::HANDLE, $templateTab->{TemplateTab::HANDLE})
                ->first();

            if (!$templateTabModel)
            {
                $templateTabModel = TemplateTab::create([
                    TemplateTab::HANDLE => $templateTab->{TemplateTab::HANDLE},
                    TemplateTab::NAME => $templateTab->{TemplateTab::NAME},
                    TemplateTab::POSITION => $position,
                    TemplateTab::TEMPLATE_ID => $templateModel->{Template::ID},
                ]);
            }
            else
            {
                $templateTabModel->update([
                    TemplateTab::NAME => $templateTab->{TemplateTab::NAME},
                    TemplateTab::POSITION => $position,
                ]);
            }

            $templateTabElements = $templateTab->{TemplateTab::RELATION_ELEMENTS} ?? [];

            foreach ($templateTabElements as $position => $templateTabElement)
            {
                $element = $templateTabElement->{BlockElement::RELATION_ELEMENT};

                if (!$element)
                {
                    continue;
                }

                if ($element instanceof Field)
                {
                    $element = $this->saveField($element);
                }
                else if ($element instanceof Block)
                {
                    $element = $this->saveBlock($element);
                }

                TemplateTabElement::create([
                    TemplateTabElement::ELEMENT_ID => $element->getKey(),
                    TemplateTabElement::ELEMENT_TYPE => $element->getTable(),
                    TemplateTabElement::HANDLE => $templateTabModel->{TemplateTabElement::HANDLE} ?? $element->{TemplateTabElement::HANDLE},
                    TemplateTabElement::NAME => $element->{TemplateTabElement::NAME},
                    TemplateTabElement::OWNER_UUID => $templateTabModel->getKey(),
                    TemplateTabElement::POSITION => $position,
                    TemplateTabElement::REQUIRED => $templateTabElement->{TemplateTabElement::REQUIRED} ?? $element->{TemplateTabElement::REQUIRED} ?? false,
                    TemplateTabElement::TRANSLATABLE => $templateTabElement->{TemplateTabElement::TRANSLATABLE} ?? $element->{TemplateTabElement::TRANSLATABLE} ?? false,
                    TemplateTabElement::WIDTH => $templateTabModel->{TemplateTabElement::WIDTH} ?? 100,
                ]);
            }
        }

        return $templateModel;
    }

    #endregion
}
