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
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateService
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     *
     * @return Collection<Field>
     */
    public static function getFields(Template $template): Collection
    {
        return $template->{Template::RELATION_SECTIONS}
            ->flatMap(fn($templateSection) => static::getSectionFields($templateSection));
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

            return $blockElement->{BlockElement::ELEMENT_TYPE} === Field::class
                ? [$element]
                : static::getBlockFields($element);
        });
    }

    /**
     * @param TemplateSection $templateSection
     *
     * @return Collection<Field>
     */
    protected static function getSectionFields(TemplateSection $templateSection): Collection
    {
        return $templateSection->{TemplateSection::RELATION_ELEMENTS}->flatMap(function ($templateSectionElement)
        {
            $element = $templateSectionElement->{TemplateSectionElement::RELATION_ELEMENT};

            return $templateSectionElement->{TemplateSectionElement::ELEMENT_TYPE} === Field::class
                ? [$element]
                : static::getBlockFields($element);
        });
    }

    #endregion
}
