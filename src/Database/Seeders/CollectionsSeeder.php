<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\FieldBlock;
use Narsil\Models\Collections\FieldOption;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class CollectionsSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * @var array
     */
    private const FIELD_FILLABLE_ATTRIBUTES = [
        Field::HANDLE,
        Field::LABEL,
        Field::DESCRIPTION,
    ];

    #endregion

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
            Block::COLLAPSIBLE => $block->{Block::COLLAPSIBLE} ?? false,
            Block::HANDLE => $block->{Block::HANDLE},
            Block::LABEL => $block->{Block::LABEL},
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
                foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                {
                    if (empty($element->getAttribute($attribute)))
                    {
                        $element->setAttribute($attribute, $blockElement->{$attribute});
                    }
                }

                $element = $this->saveField($element, [
                    Field::HANDLE => $blockElement->{BlockElement::HANDLE} ?? $element->{BlockElement::HANDLE},
                    Field::LABEL => $element->{BlockElement::LABEL},
                ]);
            }
            else if ($element instanceof Block)
            {
                $element = $this->saveBlock($element);
            }

            $blockElementModel = BlockElement::create([
                BlockElement::ELEMENT_ID => $element->getKey(),
                BlockElement::ELEMENT_TYPE => $element->getTable(),
                BlockElement::HANDLE => $blockElement->{BlockElement::HANDLE} ?? $element->{BlockElement::HANDLE},
                BlockElement::LABEL => $element->{BlockElement::LABEL},
                BlockElement::OWNER_ID => $model->getKey(),
                BlockElement::POSITION => $position,
                BlockElement::REQUIRED => $blockElement->{BlockElement::REQUIRED} ?? $element->{BlockElement::REQUIRED} ?? false,
                BlockElement::TRANSLATABLE => $blockElement->{BlockElement::TRANSLATABLE} ?? $element->{BlockElement::TRANSLATABLE} ?? false,
                BlockElement::WIDTH => $blockElement->{BlockElement::WIDTH} ?? 100,
            ]);

            $blockElementModel->conditions()->createMany($blockElement->{BlockElement::RELATION_CONDITIONS});
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
            Field::LABEL => $field->{Field::LABEL},
            Field::SETTINGS => $field->{Field::SETTINGS},
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
                    TemplateTab::LABEL => $templateTab->{TemplateTab::LABEL},
                    TemplateTab::POSITION => $position,
                    TemplateTab::TEMPLATE_ID => $templateModel->{Template::ID},
                ]);
            }
            else
            {
                $templateTabModel->update([
                    TemplateTab::LABEL => $templateTab->{TemplateTab::LABEL},
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
                    foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                    {
                        if (empty($element->getAttribute($attribute)))
                        {
                            $element->setAttribute($attribute, $templateTabElement->{$attribute});
                        }
                    }

                    $element = $this->saveField($element);
                }
                else if ($element instanceof Block)
                {
                    $element = $this->saveBlock($element);
                }

                $templateTabElementModel = TemplateTabElement::create([
                    TemplateTabElement::DESCRIPTION => $templateTabModel->{TemplateTabElement::DESCRIPTION},
                    TemplateTabElement::ELEMENT_ID => $element->getKey(),
                    TemplateTabElement::ELEMENT_TYPE => $element->getTable(),
                    TemplateTabElement::HANDLE => $templateTabModel->{TemplateTabElement::HANDLE},
                    TemplateTabElement::LABEL => $element->{TemplateTabElement::LABEL},
                    TemplateTabElement::OWNER_UUID => $templateTabModel->getKey(),
                    TemplateTabElement::POSITION => $position,
                    TemplateTabElement::REQUIRED => $templateTabElement->{TemplateTabElement::REQUIRED} ?? false,
                    TemplateTabElement::TRANSLATABLE => $templateTabElement->{TemplateTabElement::TRANSLATABLE} ?? false,
                    TemplateTabElement::WIDTH => $templateTabModel->{TemplateTabElement::WIDTH} ?? 100,
                ]);

                $templateTabElementModel->conditions()->createMany($templateTabElement->{TemplateTabElement::RELATION_CONDITIONS});
            }
        }

        return $templateModel;
    }

    #endregion
}
