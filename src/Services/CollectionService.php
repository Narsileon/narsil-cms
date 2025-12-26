<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class CollectionService
{
    #region PUBLIC METHODS

    /**
     * @param Block $block
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getBlockFields(Block $block, ?string $type = null): Collection
    {
        return $block->{Block::RELATION_ELEMENTS}
            ->flatMap(function ($blockElement)
            {
                $element = $blockElement->{BlockElement::RELATION_ELEMENT};

                if ($blockElement->{BlockElement::ELEMENT_TYPE} === Field::class)
                {
                    if ($element->{Field::TYPE} === BuilderField::class)
                    {
                        return [];
                    }

                    $field = clone $element;

                    $field->{Field::HANDLE} = $blockElement->{BlockElement::HANDLE};
                    $field->{Field::NAME} = $blockElement->{BlockElement::NAME};

                    return [$field];
                }

                return static::getBlockFields($element);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    /**
     * @param integer|string $collection
     *
     * @return ?Template
     */
    public static function getTemplate(int|string $collection): ?Template
    {
        $query = Template::query()
            ->with([
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_BlOCKS,
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_FIELDS,
            ]);

        if (is_numeric($collection))
        {
            $template = $query
                ->firstWhere(Template::ID, '=', $collection);
        }
        else
        {
            $template = $query
                ->firstWhere(Template::HANDLE, '=', $collection);
        }

        return $template;
    }

    /**
     * @param Template $template
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getTemplateFields(Template $template, ?string $type = null): Collection
    {
        return $template->{Template::RELATION_SECTIONS}
            ->flatMap(function ($templateSection)
            {
                return static::getTemplateSectionFields($templateSection);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    /**
     * @param TemplateSection $templateSection
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getTemplateSectionFields(TemplateSection $templateSection, ?string $type = null): Collection
    {
        return $templateSection->{TemplateSection::RELATION_ELEMENTS}
            ->flatMap(function ($templateSectionElement)
            {
                $element = $templateSectionElement->{TemplateSectionElement::RELATION_ELEMENT};

                if ($templateSectionElement->{TemplateSectionElement::ELEMENT_TYPE} === Field::class)
                {
                    if ($element->{Field::TYPE} === BuilderField::class)
                    {
                        return [];
                    }

                    $field = clone $element;

                    $field->{Field::HANDLE} = $templateSectionElement->{TemplateSectionElement::HANDLE};
                    $field->{Field::NAME} = $templateSectionElement->{TemplateSectionElement::NAME};

                    return [$field];
                }

                return static::getBlockFields($element);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    #endregion
}
