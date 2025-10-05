<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Collection;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class TemplateService
{
    #region PUBLIC METHODS

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
                return $collection->where('type', $type);
            });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Block $block
     *
     * @return Collection<Field>
     */
    protected static function getBlockFields(Block $block): Collection
    {
        return $block->{Block::RELATION_ELEMENTS}->flatMap(function ($blockElement)
        {
            $element = $blockElement->{BlockElement::RELATION_ELEMENT};

            if ($blockElement->{BlockElement::ELEMENT_TYPE} === Field::class)
            {
                $field = clone $element;

                $field->{Field::HANDLE} = $blockElement->{BlockElement::HANDLE};
                $field->{Field::NAME} = $blockElement->{BlockElement::NAME};

                return [$field];
            }

            return static::getBlockFields($element);
        });
    }

    /**
     * @param TemplateSection $templateSection
     *
     * @return Collection<Field>
     */
    protected static function getTemplateSectionFields(TemplateSection $templateSection): Collection
    {
        return $templateSection->{TemplateSection::RELATION_ELEMENTS}->flatMap(function ($templateSectionElement)
        {
            $element = $templateSectionElement->{TemplateSectionElement::RELATION_ELEMENT};

            if ($templateSectionElement->{TemplateSectionElement::ELEMENT_TYPE} === Field::class)
            {
                $field = clone $element;

                $field->{Field::HANDLE} = $templateSectionElement->{TemplateSectionElement::HANDLE};
                $field->{Field::NAME} = $templateSectionElement->{TemplateSectionElement::NAME};

                return [$field];
            }

            return static::getBlockFields($element);
        });
    }

    #endregion
}
