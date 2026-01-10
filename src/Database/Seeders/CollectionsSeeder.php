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

        $elements = $block->{Block::RELATION_ELEMENTS} ?? [];

        foreach ($elements as $position => $element)
        {
            $base = $element->{BlockElement::RELATION_BASE};

            if (!$base)
            {
                continue;
            }

            if ($base instanceof Field)
            {
                foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                {
                    if (empty($base->getAttribute($attribute)))
                    {
                        $base->setAttribute($attribute, $element->{$attribute});
                    }
                }

                $base = $this->saveField($base);
            }
            else if ($base instanceof Block)
            {
                $base = $this->saveBlock($base);
            }

            $elementModel = BlockElement::create([
                BlockElement::BASE_ID => $base->getKey(),
                BlockElement::BASE_TYPE => $base->getTable(),
                BlockElement::DESCRIPTION => $element->{BlockElement::DESCRIPTION},
                BlockElement::HANDLE => $element->{BlockElement::HANDLE},
                BlockElement::LABEL => $element->{BlockElement::LABEL},
                BlockElement::OWNER_ID => $model->getKey(),
                BlockElement::POSITION => $position,
                BlockElement::REQUIRED => $element->{BlockElement::REQUIRED} ?? false,
                BlockElement::TRANSLATABLE => $element->{BlockElement::TRANSLATABLE} ?? false,
                BlockElement::WIDTH => $element->{BlockElement::WIDTH} ?? 100,
            ]);

            $elementModel->conditions()->createMany($element->{BlockElement::RELATION_CONDITIONS});
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

            $elements = $templateTab->{TemplateTab::RELATION_ELEMENTS} ?? [];

            foreach ($elements as $position => $element)
            {
                $base = $element->{BlockElement::RELATION_BASE};

                if (!$base)
                {
                    continue;
                }

                if ($base instanceof Field)
                {
                    foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                    {
                        if (empty($base->getAttribute($attribute)))
                        {
                            $base->setAttribute($attribute, $element->{$attribute});
                        }
                    }

                    $base = $this->saveField($base);
                }
                else if ($base instanceof Block)
                {
                    $base = $this->saveBlock($base);
                }

                $elementModel = TemplateTabElement::create([
                    TemplateTabElement::BASE_ID => $base->getKey(),
                    TemplateTabElement::BASE_TYPE => $base->getTable(),
                    TemplateTabElement::DESCRIPTION => $element->{TemplateTabElement::DESCRIPTION},
                    TemplateTabElement::HANDLE => $element->{TemplateTabElement::HANDLE},
                    TemplateTabElement::LABEL => $element->{TemplateTabElement::LABEL},
                    TemplateTabElement::OWNER_UUID => $templateTabModel->getKey(),
                    TemplateTabElement::POSITION => $position,
                    TemplateTabElement::REQUIRED => $element->{TemplateTabElement::REQUIRED} ?? false,
                    TemplateTabElement::TRANSLATABLE => $element->{TemplateTabElement::TRANSLATABLE} ?? false,
                    TemplateTabElement::WIDTH => $element->{TemplateTabElement::WIDTH} ?? 100,
                ]);

                $elementModel->conditions()->createMany($element->{TemplateTabElement::RELATION_CONDITIONS});
            }
        }

        return $templateModel;
    }

    #endregion
}
